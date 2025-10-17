@echo off
title 🚀 TENANGIN-APP Multi-Service Starter (inside /api-ai)
echo ==========================================
echo 🚀 Starting TENANGIN Platform Environment
echo ==========================================

REM === 1. Aktifkan Virtual Env & Jalankan FastAPI ===
echo [1/4] 🧠 Starting FastAPI backend (port 5000)...

if not exist myenv (
    echo 🧩 Creating virtual environment 'myenv'...
    python -m venv myenv
)

call myenv\Scripts\activate

if not exist myenv\Lib\site-packages\fastapi (
    echo 📦 Installing Python dependencies...
    pip install -r requirements.txt
)

if not exist .env (
    echo ⚠️  Missing .env file in api-ai!
    pause
    exit /b
)

REM === Jalankan FastAPI di port 5000 ===
start cmd /k "title 🧠 FastAPI Server & cd /d %cd% && .\myenv\Scripts\activate && uvicorn main:app --reload --host 127.0.0.1 --port 5000"

cd ../core

REM === 2. Jalankan Laravel backend (port 8000) ===
echo [2/4] 💻 Starting Laravel backend (port 8000)...
start cmd /k "title 💻 Laravel Server & cd /d %cd% && php artisan serve --port=8000"

REM === 3. Jalankan Queue Worker ===
echo [3/4] ⚙️ Starting Laravel queue worker...
start cmd /k "title ⚙️ Laravel Queue & cd /d %cd% && php artisan queue:work"

REM === 4. Jalankan npm dev frontend ===
echo [4/4] 🌐 Starting NPM frontend (port 5173)...
start cmd /k "title 🌐 Frontend Dev & cd /d %cd% && npm run dev -- --port 5173"

cd ../api-ai

echo ==========================================
echo ✅ All TENANGIN services are now running!
echo ==========================================
echo.
echo 🧠 FastAPI Docs : http://127.0.0.1:5000/docs
echo 💻 Laravel App  : http://127.0.0.1:8000/
echo 🌐 Frontend Dev : http://127.0.0.1:5173/
echo.
pause
