<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePenangananRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('manajemen-curhat') ?? false;
    }

    public function rules(): array
    {
        return [
            'nama_penanganan' => 'required|string|max:150',
            'slug' => [
                'nullable','string','max:180',
                Rule::unique('penanganan','slug')->ignore($this->route('penanganan'))
            ],
            'deskripsi_penanganan' => 'required|string',
            'kelompok' => 'required|in:depresi,stres,anxiety',
            'status' => 'required|in:draft,published',
            'cover' => 'nullable|image|max:2048',
            'ordering' => 'nullable|integer|min:0',
        ];
    }
}
