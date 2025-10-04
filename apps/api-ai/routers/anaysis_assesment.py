from fastapi import APIRouter, HTTPException
from pydantic import BaseModel, field_validator
from typing import List, Dict

router = APIRouter(prefix="/assessment", tags=["assessment"])

# Indeks item DASS-21 per subskala (1-based → jadikan 0-based)
# (Sesuai template resmi; kalikan 2 setelah penjumlahan)  :contentReference[oaicite:5]{index=5}
DEP_IDX = [2, 4, 8, 9, 12, 15, 19]
ANX_IDX = [1, 3, 6, 7, 10, 13, 14]
STR_IDX = [0, 5, 11, 16, 17, 18, 20]

LEVELS = {
    "depression": [(0,9,"Normal"),(10,13,"Mild"),(14,20,"Moderate"),(21,27,"Severe"),(28,999,"Extremely Severe")],
    "anxiety":    [(0,7,"Normal"),(8,9,"Mild"),(10,14,"Moderate"),(15,19,"Severe"),(20,999,"Extremely Severe")],
    "stress":     [(0,14,"Normal"),(15,18,"Mild"),(19,25,"Moderate"),(26,33,"Severe"),(34,999,"Extremely Severe")]
}

class Dass21Request(BaseModel):
    answers: List[int]  # 21 angka 0..3

    @field_validator("answers")
    @classmethod
    def check_len(cls, v):
        if len(v) != 21: raise ValueError("Harus 21 jawaban (skala 0..3)")
        if any(a not in (0,1,2,3) for a in v): raise ValueError("Nilai harus 0..3")
        return v

def _sum(items, idxs): return sum(items[i] for i in idxs)

def _level(table, score):
    for lo, hi, name in table:
        if lo <= score <= hi: return name
    return "Unknown"

@router.post("/dass21")
def score_dass21(req: Dass21Request) -> Dict:
    d = _sum(req.answers, DEP_IDX) * 2
    a = _sum(req.answers, ANX_IDX) * 2
    s = _sum(req.answers, STR_IDX) * 2
    payload = {
        "scores": {"depression": d, "anxiety": a, "stress": s},
        "levels": {
            "depression": _level(LEVELS["depression"], d),
            "anxiety": _level(LEVELS["anxiety"], a),
            "stress": _level(LEVELS["stress"], s)
        },
        "note": "DASS-21 bukan alat diagnosis; hubungi profesional bila skor tinggi atau ada risiko keselamatan."
    }
    return payload
