import asyncio
from db import engine, Base # type: ignore

async def main():
    async with engine.begin() as conn:
        await conn.run_sync(Base.metadata.create_all)
    print("✅ DB connected & metadata synced (create_all)")

asyncio.run(main())
