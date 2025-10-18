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
            ['name' => 'Tenangin Goodiebag', 'points' => 750, 'image' => 'goodiebag.png'],
            ['name' => 'Tenangin Tumbler', 'points' => 1000, 'image' => 'tumbler.png'],
            ['name' => 'Smart Band', 'points' => 1250, 'image' => 'smartband.png'],
            ['name' => 'Payung', 'points' => 1000, 'image' => 'payung.png'],
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
        $user = $request->user();
        $data = $request->validated();

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama kalau ada
            if ($user->profile_photo && file_exists(storage_path('app/public/'.$user->profile_photo))) {
                unlink(storage_path('app/public/'.$user->profile_photo));
            }

            // Simpan foto baru
            $data['profile_photo'] = $request->file('profile_photo')->store('profile', 'public');
        }

        $user->update($data);

        return redirect()->route('user.index')->with('status', 'Profil berhasil diperbarui!');
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
