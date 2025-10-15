import os, asyncio, websockets, json # type: ignore
from datetime import datetime
from sqlalchemy.ext.asyncio import AsyncSession # type: ignore
from config import settings
from models import Suara
from typing import Optional

# Debounce commit biar DB gak ke-spam saat final segment banyak
COMMIT_EVERY_FINALS = 3        # commit setiap 3 final segmen
COMMIT_EVERY_SECONDS = 2.0     # atau minimal tiap 2 detik

def _deepgram_ws_url(lang: str) -> str:
    """
    Bangun URL WebSocket Deepgram realtime.
    """
    return (
        "wss://api.deepgram.com/v1/listen"
        f"?model=nova-2"
        f"&tier={settings.deepgram_tier}"
        f"&punctuate=true"
        f"&language={lang}"
    )

def _is_result_payload(data: dict) -> bool:
    """
    Beberapa payload Deepgram punya field 'type' lain (metadata, dsb).
    Kita fokus payload hasil (yang biasanya punya 'is_final' / 'channel').
    """
    if not isinstance(data, dict):
        return False
    # Kalau ada 'channel' atau 'is_final', anggap ini payload hasil
    return "channel" in data or "is_final" in data

def _extract_final_transcript(msg_json: dict) -> str:
    """
    Ekstrak teks transcript FINAL dari payload Deepgram.
    Contoh payload final:
    {
      "type": "Results",
      "channel": {
        "alternatives": [{"transcript": "..."}]
      },
      "is_final": true
    }
    """
    try:
        if msg_json.get("is_final") is True:
            ch = msg_json.get("channel") or {}
            alts = ch.get("alternatives") or []
            if alts and isinstance(alts, list):
                t = alts[0].get("transcript") or ""
                return t.strip()
    except Exception:
        pass
    return ""

async def pipe_audio_and_text(
    client_ws,
    db: AsyncSession,
    suara: Suara,
    lang: str = "id",
    save_audio: bool = True,
):
    """
    Relay WS: Browser (audio chunks) -> FastAPI -> Deepgram -> FastAPI -> Browser (JSON)
    - Append transcript FINAL ke DB (tabel 'suara', kolom 'transkripsi')
    - Simpan file audio (opsional) ke /mnt/data/suara/*.webm
    - Simpan asr_meta (provider, model, timestamp)
    """
    # Siapkan path penyimpanan audio (opsional)
    audio_path: Optional[str] = None
    file_handle = None
    if save_audio:
        base_dir = "/mnt/data/suara"
        os.makedirs(base_dir, exist_ok=True)
        ts = int(datetime.utcnow().timestamp())
        audio_path = os.path.join(base_dir, f"{suara.id}_{ts}.webm")
        file_handle = open(audio_path, "ab")

    # Koneksi ke Deepgram
    headers = [("Authorization", f"Token {settings.deepgram_api_key}")]
    dg_url = _deepgram_ws_url(lang)

    # Meta ringkas
    asr_meta = {
        "provider": "deepgram",
        "model": "nova-2",
        "tier": settings.deepgram_tier,
        "language": lang,
        "started_at": datetime.utcnow().isoformat() + "Z",
    }

    finals_since_commit = 0
    last_commit_ts = datetime.utcnow()

    try:
        async with websockets.connect(dg_url, extra_headers=headers, ping_interval=25) as dg_ws:

            async def forward_client_audio():
                """
                Terima chunk audio dari browser, forward ke Deepgram,
                dan (opsional) tulis ke file.
                """
                try:
                    async for message in client_ws.iter_bytes():
                        # kirim ke Deepgram
                        await dg_ws.send(message)
                        # simpan ke file
                        if file_handle:
                            try:
                                file_handle.write(message)
                            except Exception:
                                # jangan ganggu streaming kalau gagal tulis file
                                pass
                except Exception:
                    # koneksi dari client bisa putus tiba-tiba: aman
                    pass
                finally:
                    # tanda akhir stream ke Deepgram
                    try:
                        await dg_ws.send(json.dumps({"type": "CloseStream"}))
                    except Exception:
                        pass

            async def forward_transcripts_and_persist():
                """
                Terima pesan dari Deepgram, forward ke browser,
                dan bila final → append ke DB + debounce commit.
                """
                nonlocal finals_since_commit, last_commit_ts
                try:
                    async for msg in dg_ws:
                        # selalu forward JSON Deepgram ke browser (untuk menampilkan partial/final)
                        try:
                            await client_ws.send_text(msg)
                        except Exception:
                            # client mungkin sudah menutup
                            pass

                        # parse dan persist jika final
                        try:
                            data = json.loads(msg)
                            if not _is_result_payload(data):
                                continue

                            final_text = _extract_final_transcript(data)
                            if final_text:
                                # Append final text ke DB (hindari double-space)
                                fresh = (suara.transkripsi or "").strip()
                                new_text = (fresh + " " + final_text).strip() if fresh else final_text

                                obj = await db.get(Suara, suara.id)
                                if obj:
                                    obj.transkripsi = new_text
                                    obj.language = lang

                                    finals_since_commit += 1
                                    now = datetime.utcnow()
                                    elapsed = (now - last_commit_ts).total_seconds()

                                    if finals_since_commit >= COMMIT_EVERY_FINALS or elapsed >= COMMIT_EVERY_SECONDS:
                                        await db.commit()
                                        finals_since_commit = 0
                                        last_commit_ts = now
                        except Exception:
                            # jangan ganggu alur streaming hanya karena gagal parse/persist
                            pass
                except Exception:
                    # koneksi ke Deepgram mungkin selesai / error — biarkan finally melakukan cleanup
                    pass

            await asyncio.gather(forward_client_audio(), forward_transcripts_and_persist())

    finally:
        # Tutup file audio jika ada
        if file_handle:
            try:
                file_handle.close()
            except Exception:
                pass

        # Update kolom file_audio, language, dan asr_meta (ended_at)
        try:
            obj = await db.get(Suara, suara.id)
            if obj:
                if audio_path:
                    obj.file_audio = audio_path
                obj.language = lang
                asr_meta["ended_at"] = datetime.utcnow().isoformat() + "Z"
                # Simpan meta (ringkas; jika ingin lengkap, simpan last partial timing, dll.)
                obj.asr_meta = json.dumps(asr_meta)
                await db.commit()
        except Exception:
            # diamkan; jangan memblokir cleanup
            pass






# import os, asyncio, websockets, json # type: ignore
# from ..config import settings

# DEEPGRAM_WS_URL = f"wss://api.deepgram.com/v1/listen?model=nova-2&tier={settings.deepgram_tier}&punctuate=true&language=id"

# async def pipe_audio_and_text(client_ws):
#     # Connect to Deepgram
#     headers = [("Authorization", f"Token {settings.deepgram_api_key}")]
#     async with websockets.connect(DEEPGRAM_WS_URL, extra_headers=headers, ping_interval=25) as dg_ws:
#         async def forward_client_audio():
#             try:
#                 async for message in client_ws.iter_bytes():
#                     await dg_ws.send(message)
#             except Exception:
#                 pass
#             finally:
#                 # signal end of stream
#                 try:
#                     await dg_ws.send(json.dumps({"type":"CloseStream"}))
#                 except: pass

#         async def forward_transcripts():
#             try:
#                 async for msg in dg_ws:
#                     # Deepgram sends JSON; forward partial/final transcripts to client
#                     await client_ws.send_text(msg)
#             except Exception:
#                 pass

#         await asyncio.gather(forward_client_audio(), forward_transcripts())
