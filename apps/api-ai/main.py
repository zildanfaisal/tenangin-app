from fastapi import FastAPI # type: ignore
from fastapi.middleware.cors import CORSMiddleware # type: ignore
from config import settings
from routers import ws_stt, summary_curhat, analyze_emotion
from db import Base, engine

app = FastAPI(title="Tenangin API-AI")

# CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=settings.cors_origins or ["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Routers

app.include_router(ws_stt.router)
app.include_router(summary_curhat.router)
app.include_router(analyze_emotion.router)

@app.on_event("startup")
async def startup():
    async with engine.begin() as conn:
        await conn.run_sync(Base.metadata.create_all)


@app.get("/")
async def root():
    return {"message": "Server API-AI Tenangin berjalan"}
