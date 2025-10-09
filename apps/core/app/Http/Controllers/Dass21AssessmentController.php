<?php

namespace App\Http\Controllers;

use App\Models\Dass21Session;
use App\Models\Dass21Item;
use App\Models\Dass21Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Dass21ScoringService;
use App\Services\PenangananRecommendationService;

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

        $penanganan = $recommender->forSession($session);
        return view('dass21.result', compact('session', 'penanganan'));
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

    public function curhatDone($id)
    {
        $session = Dass21Session::findOrFail($id);
        return view('dass21.curhat_done', compact('session'));
    }


}
