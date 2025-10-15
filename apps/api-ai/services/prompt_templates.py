EXPERT_ANALYSIS_PROMPT = """Anda adalah psikolog klinis. Gunakan konteks berikut untuk menganalisis kondisi emosi pengguna.
- Skor DASS-21 (depresi, kecemasan, stres)
- Ringkasan curhatan

Tulis penjelasan yang empatik, validatif, dan actionable (≤200 kata), sertakan 3 saran coping awal dan kapan perlu konsultasi profesional.

KONTEKS:
DASS-21: Depression={dep}, Anxiety={anx}, Stress={strs}
RINGKASAN CURHAT:
{summary}
"""

EMPATHY_QUOTE_PROMPT = """Buat 1-2 kalimat singkat yang memvalidasi perasaan pengguna berdasarkan DASS-21 dan ringkasan curhat. Nada hangat, tidak menggurui (≤40 kata).
DASS-21: Depression={dep}, Anxiety={anx}, Stress={strs}
RINGKASAN:
{summary}
"""

JSON_CLASSIFIER_PROMPT = """Klasifikasikan emosi utama dan tingkatannya berdasarkan DASS-21 dan ringkasan curhat.
Balas HANYA JSON dengan schema:
{{"category": "stress|depresi|anxiety", "level": "rendah|sedang|tinggi|ekstrem"}}

DASS-21: Depression={dep}, Anxiety={anx}, Stress={strs}
RINGKASAN:
{summary}
"""
