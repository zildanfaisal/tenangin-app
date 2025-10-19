<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // 🔹 Wajib diisi & hanya angka
            'no_hp' => ['required', 'regex:/^[0-9]+$/'],

            'usia' => ['nullable', 'integer', 'min:1', 'max:120'],
            'jenis_kelamin' => ['nullable', 'string', 'in:Laki-laki,Perempuan'],
            'kesibukan' => ['nullable', 'string', 'max:100'],

            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048', // 2MB
            ],
        ];
    }

    /**
     * Custom pesan error dalam Bahasa Indonesia
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',

            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka.',

            'usia.integer' => 'Usia harus berupa angka.',
            'usia.min' => 'Usia minimal 1 tahun.',
            'usia.max' => 'Usia maksimal 120 tahun.',

            'profile_photo.image' => 'File yang diunggah harus berupa gambar.',
            'profile_photo.mimes' => 'Format gambar harus jpg, jpeg, png, gif, atau webp.',
            'profile_photo.max' => 'Ukuran gambar tidak boleh melebihi 2 MB.',
        ];
    }
}
