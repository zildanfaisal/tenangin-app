<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'no_hp'         => ['required', 'string', 'max:20'],
            'usia'          => ['required', 'integer', 'min:10'],
            'jenis_kelamin' => ['required', 'in:Laki-Laki,Perempuan'],
            'kesibukan'     => ['required', 'in:mahasiswa,siswa,karyawan,fresh graduate,profesional,wiraswasta,wirausaha'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'          => $request->name,
            'no_hp'         => $request->no_hp,
            'usia'          => $request->usia,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kesibukan'     => $request->kesibukan,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'koin'          => 0, 
        ]);

        // Event Laravel
        event(new Registered($user));

        // Assign Role Spatie
        $user->assignRole('user');

        // Auto login
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
