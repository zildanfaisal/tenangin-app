from config import settings
print("ENV:", settings.app_env)
print("DB:", settings.db_user, settings.db_host, settings.db_name)
print("OpenAI model:", settings.openai_model)
print("CORS origins:", settings.cors_origins)
