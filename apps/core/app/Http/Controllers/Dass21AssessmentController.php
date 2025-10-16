<?php

namespace App\Http\Controllers;

use App\Models\Dass21Session;
use App\Models\Dass21Item;
use App\Models\Dass21Response;
use App\Models\Penanganan;
use App\Models\Konsultan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Dass21ScoringService;
use App\Services\PenangananRecommendationService;
use Illuminate\Support\Facades\Storage;

class Dass21AssessmentController extends Controller
{
    public function index()
    {
        $sessions = Dass21Session::where('user_id', Auth::id())
            ->whereNotNull('completed_at')
            ->latest()
            ->paginate(10);
        $penanganan = Penanganan::published()
            ->orderBy('ordering')
            ->orderByDesc('id')
            ->get();
        return view('dass21.index', compact('sessions', 'penanganan'));
    }

    public function intro()
    {
        return view('dass21.dass21_intro');
    }

    public function start()
    {
        $session = Dass21Session::create(['user_id' => Auth::id()]);
        return redirect()->route('dass21.form', $session->id);
    }

    public function form($id, Request $request)
    {
        $session = Dass21Session::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($session->completed_at) {
            return redirect()->route('dass21.result', $session->id);
        }

        $items = Dass21Item::orderBy('urutan')->get();
        $existing = $session->responses()->pluck('nilai', 'dass21_item_id')->toArray();

        $itemId = $request->query('item');
        $currentItem = $itemId ? $items->where('id', $itemId)->first() : $items->first();
        $current = $items->search(fn($i) => $i->id === $currentItem->id) + 1;

        return view('dass21.form', compact('session', 'items', 'existing', 'current', 'currentItem'));
    }

    public function next(Request $request, $id)
    {
        $session = Dass21Session::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'responses' => 'required|array',
            'responses.*' => 'required|in:0,1,2,3'
        ]);

        foreach ($validated['responses'] as $itemId => $value) {
            Dass21Response::updateOrCreate(
                ['dass21_session_id' => $session->id, 'dass21_item_id' => $itemId],
                ['nilai' => (int)$value]
            );
        }

        $allItems = Dass21Item::orderBy('urutan')->get();
        $answered = $session->responses()->pluck('dass21_item_id')->toArray();

        $nextItem = $allItems->first(fn($item) => !in_array($item->id, $answered));

        // Jika semua sudah dijawab → hitung skor dan alihkan ke Curhat Intro
        if (!$nextItem) {
            $scoring = app(Dass21ScoringService::class);
            $scoring->finalize($session);
            return redirect()->route('dass21.curhatIntro', $session->id);
        }

        return redirect()->route('dass21.form', [
            'id' => $session->id,
            'item' => $nextItem->id
        ]);
    }

    public function result($id, PenangananRecommendationService $recommender)
    {
        $session = Dass21Session::with(['responses.item'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$session->completed_at) {
            return redirect()->route('dass21.form', $session->id);
        }

        // Skala severity
        $rank = [
            'Normal' => 0,
            'Risiko Ringan' => 1,
            'Risiko Sedang' => 2,
            'Parah' => 3,
            'Sangat Parah' => 4,
        ];

        $subscales = [
            'depresi' => $session->depresi_kelas,
            'anxiety' => $session->anxiety_kelas,
            'stres' => $session->stres_kelas,
        ];

        // Ambil semua kelompok dengan nilai Severe atau Extremely Severe (>= 3)
        $severeKeys = collect($subscales)
            ->filter(fn($kelas) => ($rank[$kelas] ?? 0) >= 3)
            ->keys()->all();

        if (count($severeKeys) > 0) {
            // Jika ada Severe/Extremely Severe, tampilkan semua yang memenuhi
            $penanganan = Penanganan::published()
                ->where(function($q) use ($severeKeys) {
                    foreach ($severeKeys as $key) {
                        $q->orWhereJsonContains('kelompok', $key);
                    }
                })
                ->with('steps')
                ->orderBy('ordering')
                ->get();
        } else {
            // Jika tidak ada Severe/Extremely Severe, tampilkan semua
            $penanganan = Penanganan::published()
                ->with('steps')
                ->orderBy('ordering')
                ->get();
        }

        $konsultans = Konsultan::orderByDesc('rating')->limit(3)->get();

        // 🧠 Ambil hasil analisis dari tabel analisis
        $analisis = \App\Models\Analisis::where('dass21_session_id', $session->id)
            ->where('user_id', Auth::id())
            ->latest('id')
            ->first();

        return view('dass21.result', compact('session', 'penanganan', 'konsultans', 'analisis'));
    }


    // 🔹 Halaman Curhat Intro (tampilan biru seperti gambar)
    public function curhatIntro($id)
    {
        $session = Dass21Session::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$session->completed_at) {
            return redirect()->route('dass21.form', $session->id);
        }

        return view('dass21.curhat_intro', compact('session'));
    }

    public function curhat($id)
    {
        $session = Dass21Session::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$session->completed_at) {
            return redirect()->route('dass21.form', $session->id);
        }

        return view('dass21.curhat', compact('session'));
    }

    public function saveTranscript(Request $request, $id)
    {
        $transcript = $request->input('transcript');

        Storage::disk('local')->put("curhat/session_{$id}.json", json_encode([
            'session_id' => $id,
            'transcript' => $transcript,
            'timestamp' => now()->toDateTimeString()
        ]));

        return response()->json(['success' => true]);
    }

    public function curhatDone($id)
    {
        $session = Dass21Session::findOrFail($id);
        return view('dass21.curhat_done', compact('session'));
    }


}
