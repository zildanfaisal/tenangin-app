from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from routers.summarize_speech import router as speech_router
from routers.analysis_assesment import router as dass_router
from routers.ws_stt import router as ws_router
from core import settings

app = FastAPI(title="Tenangin AI API", version="0.1.0")

app.add_middleware(
    CORSMiddleware,
    allow_origins=[o.strip() for o in settings.cors_origins],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

@app.get("/")
def health():
    return {"status": "ok", "service": "tenangin-api-ai"}

app.include_router(speech_router)
app.include_router(dass_router)
app.include_router(ws_router)
