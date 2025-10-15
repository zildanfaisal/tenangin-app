from sqlalchemy.ext.asyncio import create_async_engine, async_sessionmaker, AsyncSession # type: ignore
from sqlalchemy.orm import declarative_base # type: ignore
from config import settings

DATABASE_URL = (
    f"mysql+asyncmy://{settings.db_user}:{settings.db_pass}"
    f"@{settings.db_host}:{settings.db_port}/{settings.db_name}"
    f"?charset=utf8mb4"
)

engine = create_async_engine(DATABASE_URL, pool_pre_ping=True, pool_recycle=3600)
AsyncSessionLocal = async_sessionmaker(engine, expire_on_commit=False)
Base = declarative_base()

async def get_session() -> AsyncSession:
    async with AsyncSessionLocal() as session:
        yield session
