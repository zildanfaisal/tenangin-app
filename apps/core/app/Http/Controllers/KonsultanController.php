<?php

namespace App\Http\Controllers;

use App\Models\Konsultan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        public function riwayat()
    {
        $riwayat = [
            [
                'nama' => 'Anggia Kirana Candra',
                'foto' => 'images/konsultan/anggia.jpg',
                'spesialisasi' => 'Terapis di Universitas Negeri Surabaya',
                'pengalaman' => '10 Tahun Pengalaman',
                'tanggal' => 'Rabu, 21 Oktober 2025',
                'waktu' => '15.00 WIB',
                'rating' => 5,
                'ulasan' => '',
            ],
            [
                'nama' => 'Anggia Kirana Candra',
                'foto' => 'images/konsultan/anggia.jpg',
                'spesialisasi' => 'Terapis di Universitas Negeri Surabaya',
                'pengalaman' => '8 Tahun Pengalaman',
                'tanggal' => 'Selasa, 20 Oktober 2025',
                'waktu' => '14.30 WIB',
                'rating' => 4,
                'ulasan' => '',
            ],
        ];

        // Kirim data dummy ke view
        return view('konsultan.riwayat', compact('riwayat'));
    }

    public function pemesanan()
    {
        // 🔹 Data statis sementara
        $pemesanan = [
            [
                'nama' => 'Anggia Kirana Candra',
                'foto' => 'images/konsultan/anggia.jpg',
                'spesialisasi' => 'Terapis di Universitas Negeri Surabaya',
                'pengalaman' => '10 Tahun Pengalaman',
                'tanggal' => 'Rabu, 21 Oktober 2025',
                'waktu' => '15.00 WIB',
                'rating' => 5.0,
                'status' => 'Terjadwal',
                'aktif' => true,
            ],
            [
                'nama' => 'Anggia Kirana Candra',
                'foto' => 'images/konsultan/anggia2.jpg',
                'spesialisasi' => 'Terapis di Universitas Negeri Surabaya',
                'pengalaman' => '8 Tahun Pengalaman',
                'tanggal' => 'Rabu, 21 Oktober 2025',
                'waktu' => '15.00 WIB',
                'rating' => 5.0,
                'status' => 'Menunggu Konfirmasi',
                'aktif' => false,
            ],
        ];

        return view('konsultan.pemesanan', compact('pemesanan'));
    }

    public function detail($id)
    {
        // Ambil data konsultan dari database
        $konsultan = Konsultan::findOrFail($id);

        $ulasan = [
            [
                'nama' => 'Firaun',
                'rating' => 5.0,
                'isi' => 'Setelah beberapa bulan kerja nonstop saya mengalami burnout berat. Konsultasi dengan Bu Anggia membantu merapikan prioritas kerja dan teknik relaksasi yang bisa saya pakai saat tugas menumpuk. Sekarang saya lebih produktif tanpa merasa kehabisan tenaga.',
            ],
            [
                'nama' => 'Firaun',
                'rating' => 5.0,
                'isi' => 'Setelah beberapa bulan kerja nonstop saya mengalami burnout berat. Konsultasi dengan Bu Anggia membantu merapikan prioritas kerja dan teknik relaksasi yang bisa saya pakai saat tugas menumpuk. Sekarang saya lebih produktif tanpa merasa kehabisan tenaga.',
            ],
        ];

        return view('konsultan.detail', compact('konsultan', 'ulasan'));
    }

    public function pembayaran(Request $request, $id)
    {
        $konsultan = Konsultan::findOrFail($id);

        // Data dikirim via POST dari form Ajukan Jadwal
        $tanggal = $request->input('tanggal');
        $jam = $request->input('jam');

        $user = Auth::user();

        return view('konsultan.pembayaran', compact('konsultan', 'tanggal', 'jam', 'user'));
    }



}
