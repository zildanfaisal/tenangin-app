<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {
        $user = Auth::user();

        // Contoh daftar hadiah (bisa nanti diambil dari tabel hadiah kalau sudah dibuat)
        $rewards = [
            ['name' => 'Tenangin Goodiebag', 'points' => 750, 'image' => 'tenangin-goodiebag.png'],
            ['name' => 'Tenangin Tumbler', 'points' => 1000, 'image' => 'tenangin-tumbler.png'],
            ['name' => 'Tenangin Power Bank', 'points' => 2000, 'image' => 'tenangin-powerbank.png'],
            ['name' => 'Tenangin Hoodie', 'points' => 3500, 'image' => 'tenangin-hoodie.png'],
        ];

        return view('user.index', compact('user', 'rewards'));
    }

    public function edit(Request $request): View
    {
        return view('user.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        try {
            $user = $request->user();
            $data = $request->validated();

            if ($request->hasFile('profile_photo')) {
                // ✅ Validasi tambahan manual (kalau mau jaga-jaga)
                if ($request->file('profile_photo')->getSize() > 2 * 1024 * 1024) {
                    return back()->with('error', 'Ukuran foto tidak boleh melebihi 2 MB.');
                }

                if ($user->profile_photo && file_exists(storage_path('app/public/'.$user->profile_photo))) {
                    unlink(storage_path('app/public/'.$user->profile_photo));
                }

                $data['profile_photo'] = $request->file('profile_photo')->store('profile', 'public');
            }

            $user->update($data);

            return redirect()->route('user.index')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }


    public function deletePhoto(Request $request)
    {
        $user = $request->user();

        // Hapus file dari storage (kalau ada)
        if ($user->profile_photo && file_exists(storage_path('app/public/'.$user->profile_photo))) {
                unlink(storage_path('app/public/'.$user->profile_photo));
        }

        // Kosongkan kolom di database
        $user->update(['profile_photo' => null]);

        return back()->with('success', 'Foto profil berhasil dihapus.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
