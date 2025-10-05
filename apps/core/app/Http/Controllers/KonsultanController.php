<?php

namespace App\Http\Controllers;

use App\Models\Konsultan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class KonsultanController extends Controller
{
    public function index()
    {
        $konsultans = Konsultan::latest()->paginate(10);
        return view('konsultan.index', compact('konsultans'));
    }

    public function create()
    {
        return view('konsultan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_konsultan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
            'spesialisasi' => 'required|string|max:255',
            'pengalaman' => 'required|integer|min:0',
            'jadwal_praktik' => 'nullable|string',
            'harga' => 'nullable|numeric|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        if ($request->hasFile('foto')) {
            // Buat folder jika belum ada
            if (!File::exists(public_path('uploads/konsultan'))) {
                File::makeDirectory(public_path('uploads/konsultan'), 0755, true);
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/konsultan'), $filename);
            $validated['foto'] = 'uploads/konsultan/' . $filename;
        }

        Konsultan::create($validated);

        return redirect()->route('konsultan.index')
            ->with('success', 'Konsultan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $konsultan = Konsultan::findOrFail($id);
        return view('konsultan.show', compact('konsultan'));
    }

    public function edit($id)
    {
        $konsultan = Konsultan::findOrFail($id);
        return view('konsultan.edit', compact('konsultan'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_konsultan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
            'spesialisasi' => 'required|string|max:255',
            'pengalaman' => 'required|integer|min:0',
            'jadwal_praktik' => 'nullable|string',
            'harga' => 'nullable|numeric|min:0',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $konsultan = Konsultan::findOrFail($id);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($konsultan->foto && File::exists(public_path($konsultan->foto))) {
                File::delete(public_path($konsultan->foto));
            }
            
            // Buat folder jika belum ada
            if (!File::exists(public_path('uploads/konsultan'))) {
                File::makeDirectory(public_path('uploads/konsultan'), 0755, true);
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/konsultan'), $filename);
            $validated['foto'] = 'uploads/konsultan/' . $filename;
        }

        $konsultan->update($validated);

        return redirect()->route('konsultan.index')
            ->with('success', 'Konsultan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $konsultan = Konsultan::findOrFail($id);

        // Hapus foto jika ada
        if ($konsultan->foto && File::exists(public_path($konsultan->foto))) {
            File::delete(public_path($konsultan->foto));
        }

        $konsultan->delete();

        return redirect()->route('konsultan.index')
            ->with('success', 'Konsultan berhasil dihapus.');
    }
}