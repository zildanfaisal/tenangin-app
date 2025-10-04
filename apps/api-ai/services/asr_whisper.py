import io, base64, tempfile
from typing import Optional, Tuple, List, Dict
from openai import OpenAI
from core import settings, logger

client = OpenAI(api_key=settings.openai_api_key)

def transcribe_bytes(audio_bytes: bytes, language: Optional[str] = None) -> Dict:
    """
    Kirim audio bytes ke OpenAI Whisper dan kembalikan teks + segments (jika tersedia).
    """
    # Buat file sementara dengan ekstensi .wav agar MIME dikenali dengan baik
    with tempfile.NamedTemporaryFile(delete=True, suffix=".wav") as tmp:
        tmp.write(audio_bytes)
        tmp.flush()
        with open(tmp.name, "rb") as f:
            resp = client.audio.transcriptions.create(
                model=settings.openai_stt_model,
                file=f,
                response_format="verbose_json",
                **({"language": language} if language else {})
            )
    data = resp if isinstance(resp, dict) else resp.__dict__.get("_data", {}) or resp.__dict__
    if not data:
        # Fallback minimal
        return {"text": getattr(resp, "text", ""), "segments": []}
    segments = data.get("segments", [])
    text = data.get("text", getattr(resp, "text", ""))
    return {"text": text, "segments": segments}

def transcribe_base64(data_b64: str, language: Optional[str] = None) -> Dict:
    return transcribe_bytes(base64.b64decode(data_b64), language=language)
