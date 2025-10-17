## Voice & Analysis Integration

Environment variables:

```
PY_AI_URL=http://localhost:8001
PY_AI_TOKEN=replace_me
PY_AI_TIMEOUT=30
```

Python service (expected endpoints):

-   POST /v1/analyze-text { transcript, language?, context?, reference_id? }
-   POST /v1/analyze-audio { audio_url, language?, context?, reference_id?, callback_url? }

Laravel API (auth:sanctum):

-   POST /api/suara (audio, transkripsi?, dass21_session_id?, language?, duration_ms?)
-   GET /api/suara/{id}/status
-   POST /api/suara/{id}/transcribe (transkripsi, language?)
-   GET /api/suara/{id}/analisis
-   GET /api/analisis/{id}

Queue jobs:

-   AnalyzeTranscriptJob: calls Python `/v1/analyze-text` and persists to `analisis`.

# Install Laravel Tenangin

Project ini dibangun menggunakan **Laravel 12 + TailwindCSS**.

## Cara Install Project Tenangin

1. Clone repository:
    ```bash
    git clone https://github.com/zildanfaisal/tenangin-app.git
    ```
    ```bash
    cd tenangin-app/apps/core
    ```
2. Install depedency PHP dengan Composer
    ```bash
    composer install
    ```
3. Install depedency JS dengan NPM
    ```bash
    npm install
    ```
4. Buat database dengan nama tenangin-app

5. Copy file .env.example menjadi .env
    ```bash
    cp .env.example .env
    ```
    Setelahnya isi .env sesuaikan dengan nama database
6. Setelah sudah sesuai nama databasenya di .env, generate app key
    ```bash
    php artisan key:generate
    ```
7. Migrasi ke database
    ```bash
    php artisan migrate
    ```
8. Tes jalankan project secara lokal
    - Jalankan server Laravel
        ```bash
        php artisan serve
        ```
    - Jalankan build asset (TailwindCSS, JS, dll)
        ```bash
        npm run dev
        ```
9. Selesai, selamat anda telah berhasil install project Tenangin.
