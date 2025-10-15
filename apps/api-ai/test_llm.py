import asyncio
import os
import argparse
from services.llm import chat_once, extract_json

async def _run_default_tests() -> None:
    print("=== Test chat_once ===")
    txt = await chat_once("halo ini regi")
    print(txt)
    print()

    print("=== Test extract_json (direct JSON input) ===")
    j = await extract_json('{"category":"stress", "level":"sedang"}')
    print(j)

async def _run_chat_message(message: str) -> None:
    # Print only the model reply (raw), suitable for piping/consumption
    reply = await chat_once(message)
    print(reply)

def main() -> None:
    parser = argparse.ArgumentParser(description="Simple tests for services.llm")
    parser.add_argument("-m", "--message", help="Send a single message via chat_once and print only the reply")
    args = parser.parse_args()

    has_key = bool(os.getenv("OPENAI_API_KEY"))

    if args.message:
        if not has_key:
            print("⚠️ OPENAI_API_KEY kosong (tidak bisa panggil chat_once).")
            return
        asyncio.run(_run_chat_message(args.message))
        return

    if not has_key:
        print("⚠️ OPENAI_API_KEY kosong (lewati panggilan API).")
        # Still exercise extract_json fast-path
        asyncio.run(_run_default_tests.__wrapped__ if hasattr(_run_default_tests, "__wrapped__") else extract_json('{"category":"stress", "level":"sedang"}'))
        return

    asyncio.run(_run_default_tests())

if __name__ == "__main__":
    main()
