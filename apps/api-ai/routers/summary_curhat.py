from fastapi import APIRouter, Depends, HTTPException, Query  # type: ignore
from sqlalchemy.ext.asyncio import AsyncSession  # type: ignore
from sqlalchemy import select  # type: ignore

from db import get_session
import crud
from models import Suara, Analisis, Dass21Session
from services.llm import chat_once
from schemas import SummaryOut, TranscriptIn

router = APIRouter(prefix="/curhat", tags=["curhat"])

# ---------- 1) Buat record 'suara' baru (opsional, kalau kamu buat dari sisi Laravel boleh dilewati) ----------
@router.post("/suara", response_model=dict)
async def create_suara_record(
    user_id: int = Query(..., description="ID user (FK users)"),
    dass21_session_id: int = Query(..., description="FK ke dass21_sessions"),
    file_audio: str = Query("", description="Path/URL file audio (opsional)"),
    db: AsyncSession = Depends(get_session),
):
    # Validasi DASS session harus ada
    dass = await db.get(Dass21Session, dass21_session_id)
    if not dass:
        raise HTTPException(404, "dass21_session tidak ditemukan")

    item = await crud.create_suara(db, user_id=user_id, dass_session_id=dass21_session_id, file_audio=file_audio, transkripsi="")
    await db.commit()
    return {"ok": True, "suara_id": item.id}


# ---------- 2) Simpan/Update transkrip ke tabel 'suara' ----------
@router.post("/suara/{suara_id}/transcript", response_model=dict)
async def save_transcript(
    suara_id: int,
    body: TranscriptIn,
    db: AsyncSession = Depends(get_session)
):
    suara = await db.get(Suara, suara_id)
    if not suara:
        raise HTTPException(404, "Suara record not found")

    await crud.update_suara_transkrip(db, suara_id, body.text)
    await db.commit()
    return {"ok": True}


# ---------- 3) Buat ringkasan dari transkrip & simpan ke tabel 'analisis'. ----------
@router.post("/suara/{suara_id}/summary", response_model=SummaryOut)
async def summarize(
    suara_id: int,
    user_id: int = Query(..., description="ID user (FK users)"),
    db: AsyncSession = Depends(get_session),
):
    # Ambil suara + transkripsi
    suara = await db.get(Suara, suara_id)
    if not suara:
        raise HTTPException(404, "Suara record not found")

    if not suara.transkripsi or not suara.transkripsi.strip():
        raise HTTPException(400, "Belum ada transkripsi pada record 'suara' ini")

    # Opsional: validasi DASS session nya ada
    dass = await db.get(Dass21Session, suara.dass21_session_id)
    if not dass:
        raise HTTPException(404, "dass21_session tidak ditemukan untuk suara ini")

    # Prompt ringkas (hindari PII)
    prompt = (
        "Ringkaslah curhatan berikut dalam bahasa Indonesia (≤120 kata), "
        "rapikan struktur, hilangkan identitas personal (PII) jika ada:\n\n"
        f"{suara.transkripsi}"
    )
    summary = await chat_once(prompt)

    # Simpan/Upsert ke tabel 'analisis' (ringkasan saja, status 'pending')
    await crud.upsert_summary(
        db,
        user_id=user_id,
        suara_id=suara.id,
        dass_id=suara.dass21_session_id,
        summary=summary,
    )
    await db.commit()

    return SummaryOut(summary=summary)





# from fastapi import APIRouter, Depends, HTTPException # type: ignore
# from sqlalchemy.ext.asyncio import AsyncSession # type: ignore
# from ..db import get_session
# from .. import crud
# from ..services.llm import chat_once
# from ..services.prompt_templates import EXPERT_ANALYSIS_PROMPT
# from ..schemas import SummaryOut, TranscriptIn

# router = APIRouter(prefix="/curhat", tags=["curhat"])

# @router.post("/{session_id}/transcript", response_model=dict)
# async def save_transcript(session_id: int, body: TranscriptIn, db: AsyncSession = Depends(get_session)):
#     # Simple upsert transcript chunk (MVP: single big text)
#     await crud.add_transcript(db, session_id, body.text)
#     await db.commit()
#     return {"ok": True}

# @router.post("/{session_id}/summary", response_model=SummaryOut)
# async def summarize(session_id: int, user_id: int, db: AsyncSession = Depends(get_session)):
#     # 1) ambil gabungan transcript
#     s = await db.get(type(crud.CurhatSession.__mro__[0]), session_id)  # cheap existence check
#     if not s:
#         raise HTTPException(404, "Session not found")

#     # join seluruh teks transcript
#     from sqlalchemy import select # type: ignore
#     from ..models import CurhatTranscript
#     res = await db.execute(select(CurhatTranscript.text).where(CurhatTranscript.session_id == session_id))
#     texts = [row[0] for row in res.all()]
#     if not texts:
#         raise HTTPException(400, "No transcript text uploaded")
#     raw = "\n".join(texts)

#     # 2) prompt ringkas
#     prompt = f"Ringkaslah curhatan berikut (bahasa Indonesia, ≤120 kata, rapikan, hilangkan PII jika ada):\n\n{raw}"
#     summary = await chat_once(prompt)

#     # 3) simpan
#     await crud.set_summary(db, session_id, summary)
#     await db.commit()
#     return SummaryOut(summary=summary)
