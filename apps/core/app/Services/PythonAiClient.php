<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PythonAiClient
{
    protected string $baseUrl;
    protected ?string $token;
    protected int $timeout;

    public function __construct()
    {
        $cfg = config('services.py_ai');
        $this->baseUrl = rtrim($cfg['url'] ?? '', '/');
        $this->token = $cfg['token'] ?? null;
        $this->timeout = (int)($cfg['timeout'] ?? 30);
    }

    protected function http()
    {
        $req = Http::timeout($this->timeout);
        if ($this->token) {
            $req = $req->withToken($this->token);
        }
        return $req;
    }

    public function analyzeText(array $payload): array
    {
        $url = $this->baseUrl . '/v1/analyze-text';
        return $this->http()->post($url, $payload)->throw()->json();
    }

    public function analyzeAudio(array $payload): array
    {
        $url = $this->baseUrl . '/v1/analyze-audio';
        return $this->http()->post($url, $payload)->throw()->json();
    }
}
