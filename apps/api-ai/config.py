from pydantic_settings import BaseSettings # type: ignore
from pydantic import  AnyHttpUrl # type: ignore
from typing import List
import os
import dotenv # type: ignore

dotenv.load_dotenv()

class Settings(BaseSettings):
    app_env: str = os.getenv("APP_ENV", "dev")
    app_port: int = int(os.getenv("APP_PORT", "8081"))

    cors_origins: List[AnyHttpUrl] = []
    CORS_ORIGINS: str = os.getenv("CORS_ORIGINS", "")

    db_host: str = os.getenv("DB_HOST", "127.0.0.1")
    db_port: int = int(os.getenv("DB_PORT", "3306"))
    db_user: str = os.getenv("DB_USERNAME", "root")
    db_pass: str = os.getenv("DB_PASSWORD", "")
    db_name: str = os.getenv("DB_DATABASE", "tenangin-app")

    openai_api_key: str = os.getenv("OPENAI_API_KEY", "")
    openai_model: str = os.getenv("OPENAI_MODEL", "gpt-4o-mini")

    deepgram_api_key: str = os.getenv("testing_deepgram_tenangin", "")
    deepgram_model: str = os.getenv("DEEPGRAM_MODEL", "")

    class Config:
        case_sensitive = True

settings = Settings()
# Robustly handle CORS origins from env: support comma-separated list; ignore empty values
if (settings.CORS_ORIGINS or "").strip():
    settings.cors_origins = [o.strip() for o in settings.CORS_ORIGINS.split(",") if o.strip()]
