<?php

namespace App\Http\Controllers;

use App\Models\Penanganan;
use Illuminate\Http\Request;
use App\Http\Requests\StorePenangananRequest;
use App\Http\Requests\UpdatePenangananRequest;
use App\Models\Konsultan;
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
        $data['kelompok'] = $request->input('kelompok', []);
        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('penanganan','public');
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
        $data['kelompok'] = $request->input('kelompok', []);
        if ($request->hasFile('cover')) {
            if ($penanganan->cover_path) Storage::disk('public')->delete($penanganan->cover_path);
            $data['cover_path'] = $request->file('cover')->store('penanganan','public');
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
        $konsultans = Konsultan::orderByDesc('rating')->limit(3)->get();
        $steps = $penanganan->steps()->published()->get();
        $totalSteps = $steps->count();
        $totalDuration = $steps->sum('durasi_detik');
        return view('penanganan.show', compact('penanganan','steps','totalSteps','totalDuration','konsultans'));
    }
}
