from typing import Dict, Any, Literal
from openai import OpenAI
from core import settings, logger

client = OpenAI(api_key=settings.openai_api_key)

# Skema JSON keluaran yang kita minta dari model
EMO_KEYS = ["anxiety", "stress", "burnout", "ptsd", "sadness", "anger"]
RISK_LEVELS = ["none", "low", "moderate", "high", "urgent"]

def analyze_text(text: str) -> Dict[str, Any]:
    """
    Pakai Responses API + Structured Outputs agar model mengembalikan JSON yang valid.
    Hasil: summary, bullet insights, skor emosi [0..1], risk levels, dan rekomendasi triase.
    """
    json_schema = {
        "name": "TherapyAnalysis",
        "schema": {
            "type": "object",
            "properties": {
                "summary": {"type": "string"},
                "insights": {"type": "array", "items": {"type": "string"}},
                "emotions": {
                    "type": "object",
                    "additionalProperties": False,
                    "properties": {k: {"type": "number", "minimum": 0, "maximum": 1} for k in EMO_KEYS},
                    "required": EMO_KEYS
                },
                "risk_levels": {
                    "type": "object",
                    "additionalProperties": False,
                    "properties": {k: {"type": "string", "enum": RISK_LEVELS} for k in ["anxiety", "burnout", "ptsd"]},
                    "required": ["anxiety", "burnout", "ptsd"]
                },
                "recommendation": {"type": "string"},
                "red_flags": {"type": "array", "items": {"type": "string"}}
            },
            "required": ["summary", "insights", "emotions", "risk_levels", "recommendation", "red_flags"],
            "additionalProperties": False
        },
        "strict": True
    }

    system_prompt = (
        "You are a careful, supportive mental-health assistant. "
        "Summarize the user's monologue (Indonesian ok), extract key points, "
        "estimate emotion intensities [0..1], and risk levels for anxiety/burnout/PTSD. "
        "Never diagnose. If there are self-harm or harm-to-others indications, add them to red_flags "
        "and elevate risk to 'urgent' with clear, compassionate recommendation."
    )

    user_prompt = (
        "Teks curhatan pengguna:\n"
        f"{text}\n\n"
        "Buat ringkasan singkat (3–5 kalimat), bullet insight, skor emosi (0..1), "
        "risk_levels (none/low/moderate/high/urgent), rekomendasi tindak lanjut "
        "(self-help, coping, konsultasi profesional, atau bantuan darurat jika perlu). "
        "Kembalikan **hanya** JSON sesuai skema."
    )

    # Responses API + Structured Outputs
    resp = client.responses.create(
        model=settings.openai_text_model,
        input=[{"role": "system", "content": system_prompt},
               {"role": "user", "content": user_prompt}],
        response_format={"type": "json_schema", "json_schema": json_schema}
    )
    # Ambil string JSON dari output
    content = resp.output_text  # SDK mempermudah jadi string JSON langsung

    import json
    try:
        data = json.loads(content)
    except Exception as e:
        logger.exception("LLM returned non-JSON; falling back to wrapper")
        data = {"summary": content, "insights": [], "emotions": {k: 0.0 for k in EMO_KEYS},
                "risk_levels": {"anxiety":"low","burnout":"low","ptsd":"low"},
                "recommendation":"", "red_flags":[]}
    return data
