from pydantic_settings import BaseSettings
from pydantic import Field
from typing import List
import logging
import os

class Settings(BaseSettings):
    openai_api_key: str = Field(..., alias="OPENAI_API_KEY")
    openai_stt_model: str = Field(default="whisper-1", alias="OPENAI_STT_MODEL")
    openai_text_model: str = Field(default="gpt-4o-mini", alias="OPENAI_TEXT_MODEL")
    cors_origins: List[str] = Field(default=["*"], alias="CORS_ORIGINS")
    app_env: str = Field(default="dev", alias="APP_ENV")

    class Config:
        env_file = ".env"
        case_sensitive = True

settings = Settings()

# Logging ringkas
logger = logging.getLogger("api-ai")
level = logging.DEBUG if settings.app_env == "dev" else logging.INFO
logging.basicConfig(level=level, format="%(asctime)s %(levelname)s %(name)s: %(message)s")
