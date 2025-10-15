from fastapi import APIRouter, WebSocket, WebSocketDisconnect, Query # type: ignore
from sqlalchemy.ext.asyncio import AsyncSession # type: ignore
from db import AsyncSessionLocal
from models import Suara
from services.asr import pipe_audio_and_text

router = APIRouter()

@router.websocket("/ws/stt")
async def ws_stt(
    websocket: WebSocket,
    suara_id: int = Query(..., description="ID baris pada tabel 'suara'"),
    user_id: int = Query(..., description="FK users"),
    lang: str = Query("id", description="Kode bahasa Deepgram, default: id"),
    save_audio: int = Query(1, description="1 = simpan audio ke file, 0 = tidak"),
):
    await websocket.accept()

    # buka session DB untuk lifecycle WS ini
    db: AsyncSession = AsyncSessionLocal()
    suara = None  # <-- inisialisasi, supaya aman di except

    try:
        # cek record suara
        suara = await db.get(Suara, suara_id)
        if not suara:
            await websocket.send_text('{"error":"Suara record not found"}')
            await websocket.close()
            return
        if suara.user_id != user_id:
            await websocket.send_text('{"error":"User mismatch"}')
            await websocket.close()
            return

        # set status awal
        suara.status = "uploading"
        await db.commit()

        # jalankan relay + persist
        await pipe_audio_and_text(
            client_ws=websocket,
            db=db,
            suara=suara,
            lang=lang,
            save_audio=bool(save_audio),
        )

        # selesai stream → jika ada transkrip terkumpul, set status 'transcribing'
        # Jika ada transkrip, tandai transcribing
        updated = await db.get(Suara, suara_id)
        if updated and (updated.transkripsi or "").strip():
            updated.status = "transcribing"
            await db.commit()

    except WebSocketDisconnect:
        # biarkan disconnect clean
        pass
    except Exception as e:
        try:
            if suara:
                suara.status = "failed"
                await db.commit()
        except:
            pass
        # kirim error ringan ke client (tanpa detail sensitif)
        try:
            await websocket.send_text('{"error":"internal ws error"}')
        except:
            pass
    finally:
        try:
            await websocket.close()
        except:
            pass
        await db.close()





# from fastapi import APIRouter, WebSocket, WebSocketDisconnect, Query # type: ignore
# from ..services.asr import pipe_audio_and_text

# router = APIRouter()

# @router.websocket("/ws/stt")
# async def ws_stt(websocket: WebSocket, session_id: int = Query(...), user_id: int = Query(...)):
#     await websocket.accept()
#     try:
#         await pipe_audio_and_text(websocket)
#     except WebSocketDisconnect:
#         pass
#     finally:
#         await websocket.close()
