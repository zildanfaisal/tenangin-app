EXPERT_ANALYSIS_PROMPT = """Anda adalah psikolog klinis. Gunakan konteks berikut untuk menganalisis kondisi emosi pengguna.
- Skor DASS-21 (depresi, kecemasan, stres)
- Ringkasan curhatan

Tulis penjelasan yang empatik, validatif, dan actionable (≤200 kata), sertakan 3 saran coping awal dan kapan perlu konsultasi profesional.

KONTEKS:
DASS-21: Depression={dep}, Anxiety={anx}, Stress={strs}
RINGKASAN CURHAT:
{summary}
"""

EMPATHY_QUOTE_PROMPT = """
Buat satu frasa empatik yang **sangat singkat**, hanya 2–4 kata.
Tulis dalam bahasa Indonesia, bernada lembut, positif, dan menenangkan.
Jangan tulis kalimat panjang, tanda baca lebih dari satu, atau penjelasan tambahan.
Output harus **hanya** berupa frasa tanpa konteks tambahan, contoh:

Contoh yang benar:
- "Kamu nggak sendiri"
- "Aku mendengar kamu"
- "Kamu kuat"
- "Tenang, kamu aman"

Contoh yang salah:
- "Rasanya berat banget ya, kamu tidak sendiri." ❌ (terlalu panjang)
- "Menurut DASS-21 kamu..." ❌ (analitis)

DASS-21:
Depression={dep}
Anxiety={anx}
Stress={strs}

RINGKASAN:
{summary}

Tulis hasil **hanya berupa frasa 2–4 kata**, tanpa kutipan tambahan.
"""


JSON_CLASSIFIER_PROMPT = """Klasifikasikan emosi utama dan tingkatannya berdasarkan DASS-21 dan ringkasan curhat.
Balas HANYA JSON dengan schema:
{{"category": "stress|depresi|anxiety", "level": "rendah|sedang|tinggi|ekstrem"}}

DASS-21: Depression={dep}, Anxiety={anx}, Stress={strs}
RINGKASAN:
{summary}
"""
