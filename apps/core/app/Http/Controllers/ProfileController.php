<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'no_hp' => $request->input('no_hp'),
            'usia' => $request->input('usia'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'kesibukan' => $request->input('kesibukan'),
        ]);

        return Redirect::route('user.index')->with('status', 'Profil berhasil diperbarui!');
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
