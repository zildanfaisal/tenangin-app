<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyzeTranscriptJob;
use App\Models\Suara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SuaraController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'audio' => 'nullable|file|mimetypes:audio/mpeg,audio/mp3,audio/wav,audio/x-wav,audio/webm,video/webm',
            'transkripsi' => 'nullable|string',
            'dass21_session_id' => 'nullable|exists:dass21_sessions,id',
            'language' => 'nullable|string|max:10',
            'duration_ms' => 'nullable|integer|min:0',
        ]);

        // store privately on local disk (non-public)
        $path = $request->file('audio') ? $request->file('audio')->store('suara','local') : null;

        $suara = Suara::create([
            'user_id' => Auth::id(),
            'dass21_session_id' => $data['dass21_session_id'] ?? null,
            'file_audio' => $path,
            'transkripsi' => $data['transkripsi'] ?? null,
        ]);

        if (!empty($data['language'])) { $suara->language = $data['language']; }
        if (!empty($data['duration_ms'])) { $suara->duration_ms = $data['duration_ms']; }
        $suara->status = $suara->transkripsi ? 'transcribing' : 'recorded';
        $suara->save();

        // If transcript already provided, trigger analysis now
        if ($suara->transkripsi) {
            AnalyzeTranscriptJob::dispatch($suara->id);
        }

        return response()->json(['id'=>$suara->id, 'status'=>$suara->status]);
    }

    public function status(Suara $suara)
    {
        if ($suara->user_id !== Auth::id()) {
            abort(403);
        }
        return response()->json([
            'id' => $suara->id,
            'status' => $suara->status,
            'transkripsi' => $suara->transkripsi,
        ]);
    }

    public function transcribe(Request $request, Suara $suara)
    {
        if ($suara->user_id !== Auth::id()) { abort(403); }
        $data = $request->validate([
            'transkripsi' => 'required|string',
            'language' => 'nullable|string|max:10',
        ]);
        $suara->transkripsi = $data['transkripsi'];
        if (!empty($data['language'])) $suara->language = $data['language'];
        $suara->status = 'transcribing';
        $suara->save();
        AnalyzeTranscriptJob::dispatch($suara->id);
        return response()->json(['id'=>$suara->id,'status'=>$suara->status]);
    }
}
