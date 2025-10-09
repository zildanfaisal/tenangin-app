<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AiTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $exp = now()->addMinutes(10)->timestamp;
        $payload = ['sub' => $user->id, 'exp' => $exp, 'iat' => time()];
        $json = json_encode($payload);
        $b64 = rtrim(strtr(base64_encode($json), '+/', '-_'), '=');
        $secret = config('services.py_ai.shared') ?? config('services.py_ai.token');
        $sig = hash_hmac('sha256', $b64, $secret ?? '', true);
        $b64sig = rtrim(strtr(base64_encode($sig), '+/', '-_'), '=');
        $token = $b64 . '.' . $b64sig;

        $base = rtrim(
            config('services.py_ai.ws_url') ?: preg_replace('/^http/i', 'ws', rtrim(config('services.py_ai.url'), '/')),
            '/'
        );

        return response()->json([
            'token' => $token,
            'ws_url' => $base,
            'expires_at' => $exp,
        ]);
    }
}
