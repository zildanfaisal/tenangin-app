from sqlalchemy import (Column, Integer, String, Text, ForeignKey, Enum,DateTime, SmallInteger, JSON) # type: ignore
from sqlalchemy.orm import relationship # type: ignore
from db import Base

# ----------------------------
# A. DASS-21 Session (read-only)
# ----------------------------
class Dass21Session(Base):
    __tablename__ = "dass21_sessions"

    id = Column(Integer, primary_key=True)
    user_id = Column(Integer, index=True)
    depresi_kelas = Column(String(255))
    anxiety_kelas = Column(String(255))
    stres_kelas = Column(String(255))
    hasil_kelas = Column(String(255))
    overall_risk = Column(String(255))
    overall_risk_note = Column(Text)
    completed_at = Column(DateTime)
    created_at = Column(DateTime)
    updated_at = Column(DateTime)

    suara_items = relationship("Suara", back_populates="dass_session")
    analisis_items = relationship("Analisis", back_populates="dass_session")


# ----------------------------
# B. Suara (speech recognition)
# ----------------------------
class Suara(Base):
    __tablename__ = "suara"

    id = Column(Integer, primary_key=True)
    user_id = Column(Integer, index=True)
    dass21_session_id = Column(Integer, ForeignKey("dass21_sessions.id"), nullable=False)
    file_audio = Column(Text)
    transkripsi = Column(Text)
    status = Column(Enum("recorded", "uploading", "transcribing", "analyzed", "failed"))
    duration_ms = Column(Integer)
    language = Column(String(10))
    asr_meta = Column(Text)
    created_at = Column(DateTime)
    updated_at = Column(DateTime)

    dass_session = relationship("Dass21Session", back_populates="suara_items")
    analisis = relationship("Analisis", back_populates="suara", uselist=False)


# ----------------------------
# C. Analisis (LLM results)
# ----------------------------
class Analisis(Base):
    __tablename__ = "analisis"

    id = Column(Integer, primary_key=True)
    user_id = Column(Integer, index=True)
    dass21_session_id = Column(Integer, ForeignKey("dass21_sessions.id"), nullable=False)
    suara_id = Column(Integer, ForeignKey("suara.id"), nullable=False)
    hasil_kondisi = Column(Text)   # kutipan empati
    hasil_emosi = Column(Text)     # narasi ahli
    ringkasan = Column(Text)       # summary curhat
    status = Column(Enum("pending", "completed", "failed"))
    model_name = Column(String(255))
    model_version = Column(String(255))
    scores = Column(Text)
    notes = Column(Text)
    kategori_emosi = Column(String(32))  # NEW: JSON category → string
    level_emosi = Column(String(16))     # NEW: JSON level → string
    created_at = Column(DateTime)
    updated_at = Column(DateTime)

    dass_session = relationship("Dass21Session", back_populates="analisis_items")
    suara = relationship("Suara", back_populates="analisis")


# from sqlalchemy import Column, Integer, String, Text, ForeignKey, DateTime, Enum # type: ignore
# from sqlalchemy.sql import func # type: ignore
# from sqlalchemy.orm import relationship # type: ignore
# from db import Base

# class DassScore(Base):
#     __tablename__ = "dass_scores"          # milik Laravel (read-only di FastAPI)
#     id = Column(Integer, primary_key=True)
#     user_id = Column(Integer, index=True)
#     depression = Column(Integer, nullable=False)
#     anxiety = Column(Integer, nullable=False)
#     stress = Column(Integer, nullable=False)
#     created_at = Column(DateTime)
#     updated_at = Column(DateTime)

# class CurhatSession(Base):
#     __tablename__ = "curhat_sessions"
#     id = Column(Integer, primary_key=True)
#     user_id = Column(Integer, index=True)
#     status = Column(String(32), default="recording")  # recording|stopped|processed
#     created_at = Column(DateTime, server_default=func.now())

#     transcripts = relationship("CurhatTranscript", back_populates="session", cascade="all, delete-orphan", lazy="selectin")
#     summary = relationship("CurhatSummary", uselist=False, back_populates="session", lazy="selectin")
#     analysis = relationship("EmotionAnalysis", uselist=False, back_populates="session", lazy="selectin")

# class CurhatTranscript(Base):
#     __tablename__ = "curhat_transcripts"
#     id = Column(Integer, primary_key=True)
#     session_id = Column(Integer, ForeignKey("curhat_sessions.id", ondelete="CASCADE"), index=True)
#     text = Column(Text, nullable=False)
#     started_at = Column(DateTime)
#     ended_at = Column(DateTime)
#     created_at = Column(DateTime, server_default=func.now())

#     session = relationship("CurhatSession", back_populates="transcripts")

# class CurhatSummary(Base):
#     __tablename__ = "curhat_summaries"
#     id = Column(Integer, primary_key=True)
#     session_id = Column(Integer, ForeignKey("curhat_sessions.id", ondelete="CASCADE"), unique=True)
#     summary = Column(Text, nullable=False)
#     created_at = Column(DateTime, server_default=func.now())

#     session = relationship("CurhatSession", back_populates="summary")

# class EmotionAnalysis(Base):
#     __tablename__ = "emotion_analyses"
#     id = Column(Integer, primary_key=True)
#     session_id = Column(Integer, ForeignKey("curhat_sessions.id", ondelete="CASCADE"), unique=True)
#     narrative = Column(Text, nullable=False)   # output 1 (penjelasan ahli)
#     quote = Column(Text, nullable=False)       # output 2 (kutipan validasi)
#     category = Column(String(32), nullable=False)  # stress|depresi|anxiety
#     level = Column(String(16), nullable=False)     # rendah|sedang|tinggi|ekstrem
#     raw_json = Column(Text, nullable=False)    # output 3 JSON disimpan mentah
#     created_at = Column(DateTime, server_default=func.now())

#     session = relationship("CurhatSession", back_populates="analysis")
