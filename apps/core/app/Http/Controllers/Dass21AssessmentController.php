<?php

namespace App\Http\Controllers;

use App\Models\Dass21Session;
use App\Models\Dass21Item;
use App\Models\Dass21Response;
use App\Models\Penanganan;
use App\Models\Konsultan;
use App\Models\Suara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Dass21ScoringService;
use App\Services\PenangananRecommendationService;
use Illuminate\Support\Facades\Storage;

class Dass21AssessmentController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $sessions = Dass21Session::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->latest()
            ->paginate(5);

        // Ambil suara terakhir dari setiap sesi
        $suaraData = Suara::whereIn('dass21_session_id', $sessions->pluck('id'))
            ->select('dass21_session_id', 'created_at')
            ->latest('created_at')
            ->get()
            ->groupBy('dass21_session_id')
            ->map(fn($rows) => $rows->first());

        // Gabungkan data suara ke tiap session (hanya untuk item di halaman ini)
        $sessions->getCollection()->transform(function ($s) use ($suaraData) {
            $suara = $suaraData[$s->id] ?? null;
            $s->suara_created_at = $suara?->created_at;
            return $s;
        });

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

        // Ambil semua item dan jawaban existing
        $items = Dass21Item::orderBy('urutan')->get();
        $existing = $session->responses()
            ->pluck('nilai', 'dass21_item_id')
            ->toArray();

        // Tentukan item aktif
        $itemId = $request->query('item');
        $currentItem = $itemId
            ? $items->where('id', $itemId)->first()
            : $items->first();
        $current = $items->search(fn($i) => $i->id === $currentItem->id) + 1;

        return view('dass21.form', compact(
            'session',
            'items',
            'existing',
            'current',
            'currentItem'
        ));
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

        // Simpan / update nilai jawaban
        foreach ($validated['responses'] as $itemId => $value) {
            Dass21Response::updateOrCreate(
                ['dass21_session_id' => $session->id, 'dass21_item_id' => $itemId],
                ['nilai' => (int)$value]
            );
        }

        // Cari item berikutnya yang belum dijawab
        $allItems = Dass21Item::orderBy('urutan')->get();
        $answered = $session->responses()->pluck('dass21_item_id')->toArray();

        $nextItem = $allItems->first(fn($item) => !in_array($item->id, $answered));

        // Kalau semua sudah terjawab → hitung skor
        if (!$nextItem) {
            $scoring = app(Dass21ScoringService::class);
            $scoring->finalize($session);
            return redirect()->route('dass21.curhatIntro', $session->id);
        }

        // Redirect ke pertanyaan berikut
        return redirect()->route('dass21.form', [
            'id' => $session->id,
            'item' => $nextItem->id
        ]);
    }

    // public function form($id, Request $request)
    // {
    //     $session = Dass21Session::where('id', $id)
    //         ->where('user_id', Auth::id())
    //         ->firstOrFail();

    //     if ($session->completed_at) {
    //         return redirect()->route('dass21.result', $session->id);
    //     }

    //     $items = Dass21Item::orderBy('urutan')->get();
    //     $existing = $session->responses()->pluck('nilai', 'dass21_item_id')->toArray();

    //     $itemId = $request->query('item');
    //     $currentItem = $itemId ? $items->where('id', $itemId)->first() : $items->first();
    //     $current = $items->search(fn($i) => $i->id === $currentItem->id) + 1;

    //     return view('dass21.form', compact('session', 'items', 'existing', 'current', 'currentItem'));
    // }

    // public function next(Request $request, $id)
    // {
    //     $session = Dass21Session::where('id', $id)
    //         ->where('user_id', Auth::id())
    //         ->firstOrFail();

    //     $validated = $request->validate([
    //         'responses' => 'required|array',
    //         'responses.*' => 'required|in:0,1,2,3'
    //     ]);

    //     foreach ($validated['responses'] as $itemId => $value) {
    //         Dass21Response::updateOrCreate(
    //             ['dass21_session_id' => $session->id, 'dass21_item_id' => $itemId],
    //             ['nilai' => (int)$value]
    //         );
    //     }

    //     $allItems = Dass21Item::orderBy('urutan')->get();
    //     $answered = $session->responses()->pluck('dass21_item_id')->toArray();

    //     $nextItem = $allItems->first(fn($item) => !in_array($item->id, $answered));

    //     // Jika semua sudah dijawab → hitung skor dan alihkan ke Curhat Intro
    //     if (!$nextItem) {
    //         $scoring = app(Dass21ScoringService::class);
    //         $scoring->finalize($session);
    //         return redirect()->route('dass21.curhatIntro', $session->id);
    //     }

    //     return redirect()->route('dass21.form', [
    //         'id' => $session->id,
    //         'item' => $nextItem->id
    //     ]);
    // }

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

        $labels = [
            'Normal' => 'Risiko Rendah',
            'Risiko Ringan' => 'Risiko Ringan',
            'Risiko Sedang' => 'Risiko Sedang',
            'Parah' => 'Risiko Tinggi',
            'Sangat Parah' => 'Risiko Sangat Tinggi',
        ];

        $subscales = [
            'depresi' => $session->depresi_kelas,
            'anxiety' => $session->anxiety_kelas,
            'stres' => $session->stres_kelas,
        ];

        // Hitung risiko keseluruhan (ambil level tertinggi)
        $maxLevel = max([
            $rank[$session->depresi_kelas] ?? 0,
            $rank[$session->anxiety_kelas] ?? 0,
            $rank[$session->stres_kelas] ?? 0,
        ]);

        $overallKey = collect($rank)->flip()[$maxLevel] ?? 'Normal';
        $overallLabel = $labels[$overallKey] ?? 'Risiko Rendah';

        // Update ke database jika belum ada
        if (empty($session->overall_risk) || $session->overall_risk !== $overallLabel) {
            $session->overall_risk = $overallLabel;
            $session->save();
        }

        // Ambil semua kelompok dengan nilai >= 3 (Parah / Sangat Parah)
        $severeKeys = collect($subscales)
            ->filter(fn($kelas) => ($rank[$kelas] ?? 0) >= 3)
            ->keys()
            ->all();

        // Penentuan rekomendasi penanganan
        if (count($severeKeys) > 0) {
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
            $penanganan = Penanganan::published()
                ->with('steps')
                ->orderBy('ordering')
                ->get();
        }

        $konsultans = Konsultan::orderByDesc('rating')->limit(3)->get();

        $analisis = \App\Models\Analisis::where('dass21_session_id', $session->id)
            ->where('user_id', Auth::id())
            ->latest('id')
            ->first();

        return view('dass21.result', compact('session', 'penanganan', 'konsultans', 'analisis'));
    }

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
