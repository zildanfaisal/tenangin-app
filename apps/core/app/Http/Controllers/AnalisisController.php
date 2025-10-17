<?php

namespace App\Http\Controllers;

use App\Models\Analisis;
use App\Models\Suara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AnalisisController extends Controller
{
    public function show(Analisis $analisis)
    {
        if ($analisis->user_id !== Auth::id()) abort(403);
        return response()->json($analisis);
    }

    public function bySuara(Suara $suara)
    {
        if ($suara->user_id !== Auth::id()) abort(403);
        $list = Analisis::where('suara_id', $suara->id)->orderByDesc('id')->get();
        return response()->json($list);
    }

    // Endpoint untuk menerima hasil analisis dari Python
    public function storeFromPython(Request $request)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'dass21_session_id' => 'required|integer|exists:dass21_sessions,id',
                'suara_id' => 'required|integer|exists:suara,id',
                'hasil_kondisi' => 'nullable|string',
                'hasil_emosi' => 'nullable|string',
                'ringkasan' => 'nullable|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('AnalisisController@storeFromPython validation failed', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
        $analisis = Analisis::create($data);
        // Set status analisis ke 'completed'
        $analisis->status = 'completed';
        $analisis->save();
        // Update status suara ke 'analyzed'
        $suara = Suara::find($data['suara_id']);
        if ($suara) {
            $suara->update(['status' => 'analyzed']);
        }
        return response()->json(['success' => true, 'id' => $analisis->id]);
    }

    // Ambil hasil analisis berdasarkan suara_id
    public function getBySuaraId($suara_id)
    {
        $analisis = Analisis::where('suara_id', $suara_id)->orderByDesc('id')->first();
        if (!$analisis) {
            return response()->json(['ready' => false]);
        }
        return response()->json(['ready' => true, 'analisis' => $analisis]);
    }
}
