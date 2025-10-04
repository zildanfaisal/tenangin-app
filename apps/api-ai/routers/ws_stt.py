import asyncio, base64, time, io, wave, tempfile
from fastapi import APIRouter, WebSocket, WebSocketDisconnect
from services.asr_whisper import transcribe_bytes
from core import logger

router = APIRouter(prefix="/ws", tags=["websocket"])

"""
Protokol sederhana:
Client mengirim JSON text:
{"event":"start","sample_rate":16000}
{"event":"audio","audio_base64":"..."}  # PCM WAV chunk kecil (0.5-1.5s)
{"event":"stop"}

Server membalas:
{"event":"partial","text":"..."}  # hasil sementara
{"event":"final","text":"..."}    # hasil final saat stop
{"event":"error","message":"..."}
"""

async def _wav_from_pcm16(raw: bytes, sr: int = 16000) -> bytes:
    with io.BytesIO() as bio:
        with wave.open(bio, "wb") as wf:
            wf.setnchannels(1)
            wf.setsampwidth(2)   # 16-bit
            wf.setframerate(sr)
            wf.writeframes(raw)
        return bio.getvalue()

@router.websocket("/stt")
async def stt_stream(ws: WebSocket):
    await ws.accept()
    sample_rate = 16000
    buffer = bytearray()
    last_emit = time.time()
    try:
        while True:
            msg = await ws.receive_json()
            evt = msg.get("event")
            if evt == "start":
                sample_rate = int(msg.get("sample_rate", 16000))
                buffer.clear()
                await ws.send_json({"event":"ready"})
            elif evt == "audio":
                chunk = base64.b64decode(msg["audio_base64"])
                buffer.extend(chunk)
                # setiap ~3 detik kirim partial
                if time.time() - last_emit > 3.0 and len(buffer) > sample_rate*2:
                    wav_bytes = await _wav_from_pcm16(bytes(buffer), sample_rate)
                    partial = transcribe_bytes(wav_bytes)
                    await ws.send_json({"event":"partial","text": partial["text"]})
                    last_emit = time.time()
            elif evt == "stop":
                wav_bytes = await _wav_from_pcm16(bytes(buffer), sample_rate)
                final = transcribe_bytes(wav_bytes)
                await ws.send_json({"event":"final","text": final["text"], "segments": final.get("segments", [])})
                buffer.clear()
            else:
                await ws.send_json({"event":"error","message":"Unknown event"})
    except WebSocketDisconnect:
        logger.info("WS client disconnected")
    except Exception as e:
        await ws.send_json({"event":"error","message":str(e)})
