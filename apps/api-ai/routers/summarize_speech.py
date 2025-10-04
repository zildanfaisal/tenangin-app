from fastapi import APIRouter, UploadFile, File, Form
from fastapi import HTTPException
from typing import Optional, Dict, Any
from services.asr_whisper import transcribe_bytes
from services.llm import analyze_text
from core import logger

router = APIRouter(prefix="/speech", tags=["speech"])

@router.post("/stt")
async def stt_only(file: UploadFile = File(...), language: Optional[str] = Form(None)) -> Dict[str, Any]:
    if not file.content_type.startswith("audio/") and not file.filename.lower().endswith((".wav",".mp3",".m4a",".webm",".ogg",".flac",".mp4",".mov",".aac",".opus")):
        raise HTTPException(400, "File audio tidak valid")
    audio_bytes = await file.read()
    result = transcribe_bytes(audio_bytes, language=language)
    return {"ok": True, "text": result["text"], "segments": result.get("segments", [])}

@router.post("/analyze")
async def stt_and_analyze(
    file: UploadFile = File(...),
    language: Optional[str] = Form(None),
    session_id: Optional[str] = Form(None)
) -> Dict[str, Any]:
    """
    Laravel bisa kirim file audio; endpoint ini akan:
    1) transkrip, 2) ringkas + analisis emosi & risiko, 3) kembalikan JSON lengkap.
    """
    audio_bytes = await file.read()
    stt = transcribe_bytes(audio_bytes, language=language)
    analysis = analyze_text(stt["text"])
    payload = {
        "ok": True,
        "session_id": session_id,
        "transcript_text": stt["text"],
        "segments": stt.get("segments", []),
        "analysis": analysis
    }
    return payload
