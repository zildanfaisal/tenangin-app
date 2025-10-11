<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenangananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manajemen-curhat') ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_penanganan' => 'required|string|max:150',
            'slug' => 'nullable|string|max:180|unique:penanganan,slug',
            'deskripsi_penanganan' => 'required|string',
            'kelompok' => 'required|in:depresi,stres,anxiety',
            'status' => 'required|in:draft,published',
            'cover' => 'nullable|image|max:5000',
            'ordering' => 'nullable|integer|min:0',
        ];
    }
}
