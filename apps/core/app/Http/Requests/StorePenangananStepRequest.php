<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenangananStepRequest extends FormRequest
{
    public function authorize(): bool { return $this->user()?->can('manajemen-curhat') ?? false; }
    public function rules(): array
    {
        return [
            'judul' => 'nullable|string|max:150',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer|min:1',
            'durasi_detik' => 'required|integer|min:5|max:36000',
            'instruksi' => 'nullable|string',
            'status' => 'required|in:draft,published',
            'video' => 'nullable|file|mimetypes:video/mp4,video/webm,video/quicktime|max:102400'
        ];
    }
}
