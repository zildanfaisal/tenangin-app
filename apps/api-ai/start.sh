#!/bin/bash
# 🚀 TENANGIN-APP Multi-Service Starter (inside /api-ai)
# ----------------------------------------------
# Versi Linux/Ubuntu (bash) dari start.cmd

echo "=========================================="
echo "🚀 Starting TENANGIN Platform Environment"
echo "=========================================="

# === 1. Aktifkan Virtual Env & Jalankan FastAPI ===
echo "[1/4] 🧠 Starting FastAPI backend (port 5000)..."

if [ ! -d "myenv" ]; then
    echo "🧩 Creating virtual environment 'myenv'..."
    python3 -m venv myenv
fi

# Aktifkan virtual environment
source myenv/bin/activate

# Cek apakah FastAPI sudah terinstall
if [ ! -d "myenv/lib"*/"site-packages/fastapi" ]; then
    echo "📦 Installing Python dependencies..."
    pip install -r requirements.txt
fi

# Cek file .env
if [ ! -f ".env" ]; then
    echo "⚠️  Missing .env file in api-ai!"
    exit 1
fi

# Jalankan FastAPI di background
echo "🧠 Running FastAPI on port 5000..."
uvicorn main:app --reload --host 127.0.0.1 --port 5000 &
FASTAPI_PID=$!

# Pindah ke core/
cd ../core || exit

# === 2. Jalankan Laravel backend (port 8000) ===
echo "[2/4] 💻 Starting Laravel backend (port 8000)..."
php artisan serve --port=8000 &
LARAVEL_PID=$!

# === 3. Jalankan Queue Worker ===
echo "[3/4] ⚙️ Starting Laravel queue worker..."
php artisan queue:work &
QUEUE_PID=$!

# === 4. Jalankan npm dev frontend ===
echo "[4/4] 🌐 Starting NPM frontend (port 5173)..."
npm run dev -- --port 5173 &
NPM_PID=$!

cd ../api-ai || exit

echo "=========================================="
echo "✅ All TENANGIN services are now running!"
echo "=========================================="
echo
echo "🧠 FastAPI Docs : http://127.0.0.1:5000/docs"
echo "💻 Laravel App  : http://127.0.0.1:8000/"
echo "🌐 Frontend Dev : http://127.0.0.1:5173/"
echo

# Tunggu semua proses selesai
wait $FASTAPI_PID $LARAVEL_PID $QUEUE_PID $NPM_PID
