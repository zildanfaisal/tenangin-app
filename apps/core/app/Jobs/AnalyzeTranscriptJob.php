<?php

namespace App\Jobs;

use App\Models\Analisis;
use App\Models\Suara;
use App\Services\PythonAiClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AnalyzeTranscriptJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $suaraId;

    public function __construct(int $suaraId)
    {
        $this->suaraId = $suaraId;
    }

    public function handle(PythonAiClient $client): void
    {
        $suara = Suara::find($this->suaraId);
        if (!$suara) return;
        if (empty($suara->transkripsi)) {
            Log::warning('AnalyzeTranscriptJob: empty transcript', ['suara_id'=>$suara->id]);
            return;
        }

        try {
            $context = [];
            // Optional: attach latest DASS-21 summary if available via relation from session
            if ($suara->dass21Session) {
                $sess = $suara->dass21Session;
                $context['dass21'] = [
                    'overall_risk' => data_get($sess, 'overall_risk'),
                    'depresi' => data_get($sess, 'severities.depresi'),
                    'anxiety' => data_get($sess, 'severities.anxiety'),
                    'stres' => data_get($sess, 'severities.stres'),
                ];
            }

            $resp = $client->analyzeText([
                'transcript' => $suara->transkripsi,
                'language' => $suara->language ?? 'id',
                'context' => $context,
                'reference_id' => (string)$suara->id,
            ]);

            $result = $resp['result'] ?? [];

            $analisis = Analisis::create([
                'user_id' => $suara->user_id,
                'dass21_session_id' => $suara->dass21_session_id,
                'suara_id' => $suara->id,
                'hasil_kondisi' => $result['summary'] ?? '-',
                'hasil_emosi' => $result['primary_emotion'] ?? '-',
                'ringkasan' => $result['summary'] ?? '-',
                'status' => 'completed',
                'model_name' => data_get($result, 'model.name'),
                'model_version' => data_get($result, 'model.version'),
                'scores' => empty($result) ? null : json_encode([
                    'emotion_confidences' => $result['emotion_confidences'] ?? null,
                    'intensity' => $result['intensity'] ?? null,
                    'sentiment' => $result['sentiment'] ?? null,
                    'topics' => $result['topics'] ?? null,
                    'risk_flags' => $result['risk_flags'] ?? null,
                ]),
            ]);

            $suara->update(['status' => 'analyzed']);
        } catch (\Throwable $e) {
            Log::error('AnalyzeTranscriptJob failed', ['suara_id'=>$suara->id, 'error'=>$e->getMessage()]);
            $suara->update(['status' => 'failed']);
        }
    }
}
