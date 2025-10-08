<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenangananStep extends Model
{
    protected $fillable = [
        'penanganan_id','judul','deskripsi','urutan','durasi_detik','video_path','instruksi','status'
    ];

    public function penanganan()
    {
        return $this->belongsTo(Penanganan::class);
    }

    public function scopePublished($q){ return $q->where('status','published'); }
}
