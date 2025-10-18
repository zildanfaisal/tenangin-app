<?php

namespace App\Http\Controllers;

use App\Models\Konsultan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class KonsultanController extends Controller
{
    public function index(Request $request)
    {
        $query = Konsultan::query();

        // Filter pencarian nama
        if ($request->filled('search')) {
            $query->where('nama_konsultan', 'like', '%' . $request->search . '%');
        }
        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        // Filter jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        // Filter harga
        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }
        // Filter rating
        if ($request->filled('min_rating')) {
            $query->where('rating', '>=', $request->min_rating);
        }

        $konsultans = $query->latest()->paginate(10);
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
            'jenis_kelamin' => 'nullable|in:L,P',
            'kategori' => 'required|in:konselor,konsultan',
        ]);

        if ($request->hasFile('foto')) {
            if (!File::exists(public_path('storage/konsultan'))) {
                File::makeDirectory(public_path('storage/konsultan'), 0755, true);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/konsultan'), $filename);
            $validated['foto'] = 'storage/konsultan/' . $filename;
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
            'jenis_kelamin' => 'nullable|in:L,P',
            'kategori' => 'required|in:konselor,konsultan',
        ]);

        $konsultan = Konsultan::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($konsultan->foto && File::exists(public_path($konsultan->foto))) {
                File::delete(public_path($konsultan->foto));
            }

            if (!File::exists(public_path('storage/konsultan'))) {
                File::makeDirectory(public_path('storage/konsultan'), 0755, true);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/konsultan'), $filename);
            $validated['foto'] = 'storage/konsultan/' . $filename;
        }

        $konsultan->update($validated);

        return redirect()->route('konsultan.index')
            ->with('success', 'Konsultan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $konsultan = Konsultan::findOrFail($id);

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

        return view('konsultan.riwayat', compact('riwayat'));
    }

    public function pemesanan()
    {
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

        $tanggal = $request->input('tanggal');
        $jam = $request->input('jam');

        return redirect()->route('konsultan.bayar.qris', [
            'id' => $konsultan->id,
            'tanggal' => $tanggal,
            'jam' => $jam,
        ]);
    }

    public function qris($id, Request $r)
    {
        $konsultan = Konsultan::findOrFail($id);

        $tanggal = $r->query('tanggal');
        $jam     = $r->query('jam');
        $user    = Auth::user();

        $sid = (string) Str::uuid();
        $token = Str::random(48);

        $suffixRupiah = random_int(111, 999);
        $totalBayar = (int) $konsultan->harga + $suffixRupiah;

        Cache::put("pay:$sid", [
            'konsultan_id' => $konsultan->id,
            'total' => $totalBayar,
            'token' => $token,
            'created_at' => now()->toISOString(),
            'paid' => false,
            'user_id' => $user?->id,
        ], now()->addMinutes(30));

        $confirmUrl = route('konsultan.bayar.confirm', ['sid' => $sid]) . '?token=' . $token;
        $qrImage = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($confirmUrl);

        return view('konsultan.pembayaran', compact(
            'konsultan','tanggal','jam','sid','totalBayar','qrImage','user'
        ));
    }

    public function qrisStatus(Request $r)
    {
        $sid = $r->query('sid');
        if (!$sid) {
            return response()->json(['paid' => false, 'error' => 'missing_sid']);
        }

        $session = Cache::get("pay:$sid");
        if (!$session) {
            return response()->json(['paid' => false, 'error' => 'session_not_found']);
        }

        $paidFlag = Cache::get("pay:$sid:paid", false);
        $paid = (bool) ($paidFlag || ($session['paid'] ?? false));

        return response()->json(['paid' => $paid]);
    }

    public function confirmByScan($sid, Request $request)
    {
        $token = $request->query('token');

        $session = Cache::get("pay:$sid");
        if (!$session) {
            return redirect()->route('konsultan.bayar.sukses')->with('error', 'Session pembayaran tidak ditemukan atau sudah kedaluwarsa.');
        }

        if (!isset($session['token']) || !hash_equals($session['token'], (string)$token)) {
            return redirect()->route('konsultan.bayar.sukses')->with('error', 'Token konfirmasi tidak valid.');
        }

        $session['paid'] = true;
        Cache::put("pay:$sid", $session, now()->addHours(1));
        Cache::put("pay:$sid:paid", true, now()->addHours(1));

        return redirect()->route('konsultan.bayar.sukses')->with('success', 'Pembayaran berhasil dikonfirmasi melalui QR scan.');
    }

    public function qrisSukses()
    {
        return view('konsultan.pembayaran_sukses');
    }
}
