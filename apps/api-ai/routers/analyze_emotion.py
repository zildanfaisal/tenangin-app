from fastapi import APIRouter, Depends, HTTPException, Request  # type: ignore
from sqlalchemy.ext.asyncio import AsyncSession  # type: ignore
from sqlalchemy import select  # type: ignore
from db import get_session
import crud
from models import Suara, Analisis, Dass21Session
from services.llm import chat_once, extract_json
from services.prompt_templates import (
    EXPERT_ANALYSIS_PROMPT,
    EMPATHY_QUOTE_PROMPT,
    JSON_CLASSIFIER_PROMPT,
)
from schemas import AnalysisOut

router = APIRouter(tags=["analysis"])


# Endpoint menerima payload JSON dari Laravel
@router.post("/v1/analyze-text")
async def analyze_text(request: Request, db: AsyncSession = Depends(get_session)):
    data = await request.json()
    suara_id = int(data.get('reference_id'))
    transcript = data.get('transcript')

    # 1) Pastikan record 'suara' ada & sudah punya transkripsi
    suara = await db.get(Suara, suara_id)
    if not suara:
        raise HTTPException(404, "Suara record not found")
    suara.transkripsi = transcript
    await db.commit()
    if not suara.transkripsi or not suara.transkripsi.strip():
        raise HTTPException(400, "Transkripsi belum tersedia untuk dianalisis")

    # 2) Ambil DASS session (pakai *_kelas)
    dass = await db.get(Dass21Session, suara.dass21_session_id)
    if not dass:
        raise HTTPException(404, "DASS-21 session tidak ditemukan untuk suara ini")

    # 3) Ambil/cek ringkasan dari tabel 'analisis' untuk suara_id ini
    res = await db.execute(select(Analisis).where(Analisis.suara_id == suara_id))
    analisis_row = res.scalars().first()
    if analisis_row:
        summary = analisis_row.ringkasan if analisis_row.ringkasan else transcript
    else:
        summary = transcript

    # 4) Siapkan prompt (gunakan *_kelas)
    prompt1 = EXPERT_ANALYSIS_PROMPT.format(
        dep=dass.depresi_kelas, anx=dass.anxiety_kelas, strs=dass.stres_kelas, summary=summary
    )
    prompt2 = EMPATHY_QUOTE_PROMPT.format(
        dep=dass.depresi_kelas, anx=dass.anxiety_kelas, strs=dass.stres_kelas, summary=summary
    )
    # 5) Panggil LLM
    narrative = await chat_once(prompt1)
    quote = await chat_once(prompt2)

    if analisis_row:
        # Update baris analisis
        updated = await crud.update_analysis_results(
            db,
            suara_id=suara_id,
            narrative=narrative,
            quote=quote,
            category=None,
            level=None,
        )
        await db.commit()
    else:
        # Buat baris analisis baru
        new_analisis = Analisis(
            user_id=suara.user_id,
            dass21_session_id=suara.dass21_session_id,
            suara_id=suara_id,
            ringkasan=summary,
            hasil_emosi=narrative,
            hasil_kondisi=quote,
            status="completed",
        )
        db.add(new_analisis)
        await db.commit()

    return {
        "hasil_emosi": narrative,
        "hasil_kondisi": quote,
        "summary": summary,
    }





# from fastapi import APIRouter, Depends, HTTPException # type: ignore
# from sqlalchemy.ext.asyncio import AsyncSession # type: ignore
# from sqlalchemy import select # type: ignore
# from ..db import get_session
# from .. import crud
# from ..models import CurhatSummary
# from ..services.llm import chat_once, extract_json
# from ..services.prompt_templates import EXPERT_ANALYSIS_PROMPT, EMPATHY_QUOTE_PROMPT, JSON_CLASSIFIER_PROMPT
# from ..schemas import AnalysisOut

# router = APIRouter(prefix="/curhat", tags=["analysis"])

# @router.post("/{session_id}/analyze", response_model=AnalysisOut)
# async def analyze(session_id: int, user_id: int, db: AsyncSession = Depends(get_session)):
#     # pastikan summary ada
#     res = await db.execute(select(CurhatSummary).where(CurhatSummary.session_id == session_id))
#     row = res.scalars().first()
#     if not row:
#         raise HTTPException(400, "Summary not found. Run /summary first.")
#     summary = row.summary

#     # get DASS terkini user
#     dass = await crud.get_latest_dass(db, user_id)
#     if not dass:
#         raise HTTPException(400, "DASS-21 score not found for user.")

#     # 1) narasi ahli
#     prompt1 = EXPERT_ANALYSIS_PROMPT.format(dep=dass.depression, anx=dass.anxiety, strs=dass.stress, summary=summary)
#     narrative = await chat_once(prompt1)

#     # 2) kutipan validasi
#     prompt2 = EMPATHY_QUOTE_PROMPT.format(dep=dass.depression, anx=dass.anxiety, strs=dass.stress, summary=summary)
#     quote = await chat_once(prompt2)

#     # 3) JSON kategori & level
#     prompt3 = JSON_CLASSIFIER_PROMPT.format(dep=dass.depression, anx=dass.anxiety, strs=dass.stress, summary=summary)
#     j = await extract_json(prompt3)
#     category = j.get("category", "stress")
#     level = j.get("level", "sedang")

#     # simpan
#     saved = await crud.set_analysis(db, session_id, narrative, quote, category, level, raw_json=str(j))
#     await db.commit()

#     return AnalysisOut(narrative=narrative, quote=quote, category=category, level=level, raw_json=str(j))
