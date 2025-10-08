<?php

namespace App\Http\Controllers;

use App\Models\Penanganan;
use Illuminate\Http\Request;
use App\Http\Requests\StorePenangananRequest;
use App\Http\Requests\UpdatePenangananRequest;
use Illuminate\Support\Facades\Storage;

class PenangananController extends Controller
{
    // Middleware di-handle di routes (web.php) agar kompatibel dengan style Laravel 12 baru.

    public function index(Request $request)
    {
        $q = Penanganan::query()
            ->when($request->search, fn($qr,$s)=>$qr->where('nama_penanganan','like',"%$s%"))
            ->orderBy('ordering')
            ->orderByDesc('id');
        $items = $q->paginate(15)->withQueryString();
        return view('penanganan.index', compact('items'));
    }

    public function create()
    {
        return view('penanganan.create');
    }

    public function store(StorePenangananRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('penanganan','public');
        }
        if ($request->hasFile('video_penanganan')) {
            $data['video_penanganan'] = $request->file('video_penanganan')->store('penanganan/videos','public');
        }
        Penanganan::create($data);
        return redirect()->route('admin.penanganan.index')->with('success','Penanganan dibuat.');
    }

    public function edit(Penanganan $penanganan)
    {
        return view('penanganan.edit', compact('penanganan'));
    }

    public function update(UpdatePenangananRequest $request, Penanganan $penanganan)
    {
        $data = $request->validated();
        if ($request->hasFile('cover')) {
            if ($penanganan->cover_path) Storage::disk('public')->delete($penanganan->cover_path);
            $data['cover_path'] = $request->file('cover')->store('penanganan','public');
        }
        if ($request->hasFile('video_penanganan')) {
            if ($penanganan->video_penanganan) Storage::disk('public')->delete($penanganan->video_penanganan);
            $data['video_penanganan'] = $request->file('video_penanganan')->store('penanganan/videos','public');
        }
        $penanganan->update($data);
        return redirect()->route('admin.penanganan.index')->with('success','Penanganan diperbarui.');
    }

    public function destroy(Penanganan $penanganan)
    {
        if ($penanganan->rekamanPenanganan()->exists()) {
            return back()->with('error','Tidak dapat menghapus: sudah ada rekaman terkait.');
        }
        if ($penanganan->cover_path) Storage::disk('public')->delete($penanganan->cover_path);
        $penanganan->delete();
        return back()->with('success','Penanganan dihapus.');
    }

    // ================= PUBLIC (user authenticated) =================
    public function showPublic($slug)
    {
        $penanganan = Penanganan::published()->where('slug',$slug)->firstOrFail();
        $steps = $penanganan->steps()->published()->get();
        $totalSteps = $steps->count();
        $totalDuration = $totalSteps > 0
            ? $steps->sum('durasi_detik')
            : (int)($penanganan->durasi_detik ?? 0);
        $tahapan = [];
        if ($totalSteps === 0 && $penanganan->tahapan_penanganan) {
            $tahapan = preg_split("/\r?\n/", $penanganan->tahapan_penanganan);
        }
        return view('penanganan.show', compact('penanganan','steps','totalSteps','totalDuration','tahapan'));
    }
}
