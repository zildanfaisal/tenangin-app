from pydantic import BaseModel  # type: ignore
from typing import Optional, List

class TranscriptIn(BaseModel):
    text: str


class TranscriptOut(BaseModel):
    id: int
    text: str


class SummaryOut(BaseModel):
    summary: str


# hasil analisis (sinkron dengan tabel analisis)
class AnalysisOut(BaseModel):
    hasil_emosi: str              # narasi ahli (kolom hasil_emosi)
    hasil_kondisi: str            # kutipan empati (kolom hasil_kondisi)
    kategori_emosi: str           # dari JSON classifier
    level_emosi: str              # dari JSON classifier
    raw_json: Optional[str] = ""  # raw JSON hasil classifier (opsional)


# (Opsional)
class AnalysisLegacyOut(BaseModel):
    narrative: str
    quote: str
    category: str
    level: str
    raw_json: str


# Untuk DASS-21
class DassBrief(BaseModel):
    depresi_kelas: str
    anxiety_kelas: str
    stres_kelas: str


# from pydantic import BaseModel # type: ignore
# from typing import Optional, List

# class TranscriptIn(BaseModel):
#     text: str

# class TranscriptOut(BaseModel):
#     id: int
#     text: str

# class SummaryOut(BaseModel):
#     summary: str

# class AnalysisOut(BaseModel):
#     narrative: str
#     quote: str
#     category: str
#     level: str
#     raw_json: str

# class DassBrief(BaseModel):
#     depression: int
#     anxiety: int
#     stress: int