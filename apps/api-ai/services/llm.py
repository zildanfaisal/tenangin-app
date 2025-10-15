import json
from openai import OpenAI # type: ignore
from config import settings

client = OpenAI(api_key=settings.openai_api_key)

async def chat_once(prompt: str) -> str:
    # sync SDK; FastAPI will still handle this fine for MVP
    resp = client.chat.completions.create(
        model=settings.openai_model,
        messages=[{"role":"user","content":prompt}],
    )
    return resp.choices[0].message.content.strip()

def _strip_code_fences(text: str) -> str:
    """Remove Markdown code fences from a string if present."""
    s = text.strip()
    if s.startswith("```"):
        # Drop opening fence line (may be ``` or ```json)
        newline_idx = s.find("\n")
        if newline_idx != -1:
            s = s[newline_idx + 1 :]
        # Drop trailing fence if present
        if s.endswith("```"):
            s = s[: -3]
    return s.strip()

async def extract_json(text: str) -> dict:
    """Parse a JSON object from input text.

    - If the input is already a JSON string, parse it directly (no API call).
    - Otherwise, ask the model to extract and return ONLY a valid JSON object,
      then parse it safely (handles code fences).
    """
    # Fast path: caller already provided JSON
    try:
        direct = json.loads(text)
        if isinstance(direct, dict):
            return direct
    except json.JSONDecodeError:
        pass

    # Fallback: request JSON-only output from the model
    instruction = (
        "Ekstrak objek JSON dari teks berikut. Balas HANYA JSON valid tanpa penjelasan, "
        "tanpa code block. Jika tidak ada data, balas {}.\n\n" + text
    )
    txt = await chat_once(instruction)
    cleaned = _strip_code_fences(txt)
    data = json.loads(cleaned)
    if not isinstance(data, dict):
        raise ValueError("LLM JSON response must be an object")
    return data
