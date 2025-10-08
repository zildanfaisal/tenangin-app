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
            'tahapan_penanganan' => 'required|string',
            'tutorial_penanganan' => 'nullable|string',
            'video_penanganan' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-matroska,video/webm|max:102400',
            'status' => 'required|in:draft,published',
            'durasi_detik' => 'nullable|integer|min:10|max:36000',
            'cover' => 'nullable|image|max:2048',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
            'ordering' => 'nullable|integer|min:0',
        ];
    }
}
