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
            'tahapan_penanganan' => 'required|string',
            'tutorial_penanganan' => 'nullable|string',
            // Sekarang video berupa file upload (disimpan sebagai path di kolom video_penanganan)
            'video_penanganan' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-matroska,video/webm|max:102400', // max ~100MB
            'status' => 'required|in:draft,published',
            'durasi_detik' => 'nullable|integer|min:10|max:36000',
            'cover' => 'nullable|image|max:2048',
            'tingkat_kesulitan' => 'required|in:mudah,sedang,sulit',
            'ordering' => 'nullable|integer|min:0',
        ];
    }
}
