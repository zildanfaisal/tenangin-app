from sqlalchemy import select  # type: ignore
from sqlalchemy.ext.asyncio import AsyncSession  # type: ignore
from models import Dass21Session, Suara, Analisis
from config import settings

# --- GET DASS21 CONTEXT ---
async def get_latest_dass(session: AsyncSession, user_id: int):
    q = (
        select(Dass21Session)
        .where(Dass21Session.user_id == user_id)
        .order_by(Dass21Session.completed_at.desc())
        .limit(1)
    )
    res = await session.execute(q)
    return res.scalars().first()

# --- INSERT SPEECH RECORD / UPDATE TRANSKRIPSI ---
async def create_suara(session: AsyncSession, user_id: int, dass_session_id: int, file_audio: str, transkripsi: str = None):
    item = Suara(
        user_id=user_id,
        dass21_session_id=dass_session_id,
        file_audio=file_audio,
        transkripsi=transkripsi or "",
        status="recorded",
        language="id",
    )
    session.add(item)
    await session.flush()
    return item

async def update_suara_transkrip(session: AsyncSession, suara_id: int, text: str):
    suara = await session.get(Suara, suara_id)
    if suara:
        suara.transkripsi = text
        # biarkan status ditangani lifecycle WS/route; di sini aman set ke 'transcribing'
        suara.status = "transcribing"
    return suara

# --- ANALISIS: upsert summary (buat baris analisis jika belum ada) ---
async def upsert_summary(session: AsyncSession, user_id: int, suara_id: int, dass_id: int, summary: str):
    q = select(Analisis).where(Analisis.suara_id == suara_id)
    res = await session.execute(q)
    row = res.scalars().first()

    if row:
        row.ringkasan = summary
        if row.status != "completed":
            row.status = "pending"
        return row

    a = Analisis(
        user_id=user_id,
        dass21_session_id=dass_id,
        suara_id=suara_id,
        ringkasan=summary,
        status="pending",
        model_name=settings.openai_model,
        model_version="2025.10",
    )
    session.add(a)
    await session.flush()
    return a

# --- ANALISIS: update hasil akhir (narasi, kutipan, kategori, level) ---
async def update_analysis_results(session: AsyncSession, suara_id: int, narrative: str, quote: str, category=None, level=None):
    q = select(Analisis).where(Analisis.suara_id == suara_id)
    res = await session.execute(q)
    row = res.scalars().first()
    if not row:
        return None
    row.hasil_emosi = narrative
    row.hasil_kondisi = quote
    row.status = "completed"
    return row

# --- (Opsional) Buat baris analisis sekaligus seluruh hasil (legacy) ---
async def save_analysis(session: AsyncSession, user_id: int, dass_id: int, suara_id: int, summary: str, narasi: str, quote: str, category: str, level: str):
    a = Analisis(
        user_id=user_id,
        dass21_session_id=dass_id,
        suara_id=suara_id,
        ringkasan=summary,
        hasil_emosi=narasi,
        hasil_kondisi=quote,
        kategori_emosi=category,
        level_emosi=level,
        status="completed",
        model_name=settings.openai_model,
    )
    session.add(a)
    await session.flush()
    return a






# from sqlalchemy import select # type: ignore
# from sqlalchemy.ext.asyncio import AsyncSession # type: ignore
# from .models import CurhatSession, CurhatTranscript, CurhatSummary, EmotionAnalysis, DassScore

# async def get_latest_dass(session: AsyncSession, user_id: int):
#     q = select(DassScore).where(DassScore.user_id == user_id).order_by(DassScore.created_at.desc()).limit(1)
#     res = await session.execute(q)
#     return res.scalars().first()

# async def create_session(session: AsyncSession, user_id: int) -> CurhatSession:
#     s = CurhatSession(user_id=user_id)
#     session.add(s); await session.flush()
#     return s

# async def add_transcript(session: AsyncSession, session_id: int, text: str) -> CurhatTranscript:
#     t = CurhatTranscript(session_id=session_id, text=text)
#     session.add(t); await session.flush()
#     return t

# async def set_summary(session: AsyncSession, session_id: int, summary: str) -> CurhatSummary:
#     s = CurhatSummary(session_id=session_id, summary=summary)
#     session.add(s); await session.flush()
#     return s

# async def set_analysis(session: AsyncSession, session_id: int, narrative: str, quote: str, category: str, level: str, raw_json: str):
#     a = EmotionAnalysis(session_id=session_id, narrative=narrative, quote=quote, category=category, level=level, raw_json=raw_json)
#     session.add(a); await session.flush()
#     return a
