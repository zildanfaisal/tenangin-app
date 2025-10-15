import requests
from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route('/v1/analyze-text', methods=['POST'])
def analyze_text():
    data = request.get_json()
    transcript = data.get('transcript')
    reference_id = data.get('reference_id')
    # Analisis sederhana: hitung jumlah kata
    word_count = len(transcript.split())

    # Ambil data suara dari Laravel
    suara_url = f"http://localhost:8000/api/suara/{reference_id}/status"
    try:
        suara_resp = requests.get(suara_url)
        suara_data = suara_resp.json()
        user_id = suara_data.get('user_id')
        dass21_session_id = suara_data.get('dass21_session_id')
    except Exception as e:
        print("Gagal ambil data suara:", e)
        user_id = None
        dass21_session_id = None

    # Hasil analisis
    result = {
        "summary": f"Jumlah kata: {word_count}",
        "primary_emotion": "netral",
        "model": {"name": "dummy", "version": "0.1"}
    }

    # Kirim hasil ke Laravel
    laravel_url = "http://localhost:8000/api/analisis/hasil"
    payload = {
        "user_id": user_id,
        "dass21_session_id": dass21_session_id,
        "suara_id": reference_id,
        "hasil_kondisi": result["summary"],
        "hasil_emosi": result["primary_emotion"],
        "ringkasan": result["summary"]
    }
    try:
        r = requests.post(laravel_url, json=payload)
        print("Laravel response:", r.text)
    except Exception as e:
        print("Gagal kirim ke Laravel:", e)

    return jsonify({"result": result})

if __name__ == '__main__':
    app.run(port=5000)