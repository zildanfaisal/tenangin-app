<?php

namespace App\Http\Controllers;

use App\Models\Dass21Session;
use App\Models\Dass21Item;
use App\Models\Dass21Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Dass21ScoringService;

class Dass21AssessmentController extends Controller
{
    public function index()
    {
        $sessions = Dass21Session::where('user_id', Auth::id())->latest()->paginate(10);
        return view('dass21.index', compact('sessions'));
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
    public function next(Request $request, $id)
    {
        $session = Dass21Session::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Validasi input: pastikan hanya satu jawaban yang dikirim
        $validated = $request->validate([
            'responses' => 'required|array',
            'responses.*' => 'required|in:0,1,2,3'
        ]);

        // Ambil kunci (id item) dan nilai
        foreach ($validated['responses'] as $itemId => $value) {
            Dass21Response::updateOrCreate(
                ['dass21_session_id' => $session->id, 'dass21_item_id' => $itemId],
                ['nilai' => (int)$value]
            );
        }

        // Hitung posisi sekarang
        $allItems = Dass21Item::orderBy('urutan')->get();
        $answered = $session->responses()->pluck('dass21_item_id')->toArray();

        // Cari soal berikutnya yang belum dijawab
        $nextItem = $allItems->first(function ($item) use ($answered) {
            return !in_array($item->id, $answered);
        });

        // Jika semua soal sudah dijawab, arahkan ke submit final
        if (!$nextItem) {
            $scoring = app(\App\Services\Dass21ScoringService::class);
            $scoring->finalize($session);
            return redirect()->route('dass21.result', $session->id);
        }

        // Redirect ke form dengan soal berikutnya
        return redirect()->route('dass21.form', [
            'id' => $session->id,
            'item' => $nextItem->id
        ]);
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

        // ambil item_id dari query ?item=...
        $itemId = $request->query('item');
        $currentItem = $itemId ? $items->where('id', $itemId)->first() : $items->first();

        // tentukan urutan saat ini
        $current = $items->search(fn($i) => $i->id === $currentItem->id) + 1;

        return view('dass21.form', compact('session', 'items', 'existing', 'current', 'currentItem'));
    }


    public function submit(Request $request, $id, Dass21ScoringService $scoring)
    {
        $session = Dass21Session::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $items = Dass21Item::pluck('id')->toArray();
        $validated = $request->validate([
            'responses' => 'required|array|size:21',
            'responses.*' => 'required|in:0,1,2,3'
        ]);
        foreach ($validated['responses'] as $itemId => $value) {
            if (!in_array((int)$itemId, $items)) continue;
            Dass21Response::updateOrCreate(
                ['dass21_session_id' => $session->id, 'dass21_item_id' => $itemId],
                ['nilai' => (int)$value]
            );
        }
        if ($session->responses()->count() === 21) {
            $scoring->finalize($session);
            return redirect()->route('dass21.result', $session->id);
        }
        return back()->with('error', 'Jawaban belum lengkap');
    }

    public function result($id)
    {
        $session = Dass21Session::with(['responses.item'])->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        if (!$session->completed_at) {
            return redirect()->route('dass21.form', $session->id);
        }
        return view('dass21.result', compact('session'));
    }
}
