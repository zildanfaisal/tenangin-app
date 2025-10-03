<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penanganan extends Model
{
    use HasFactory;

    protected $table = 'penanganan';

    protected $fillable = [
        'nama_penanganan',
        'deskripsi_penanganan',
        'tahapan_penanganan',
        'tutorial_penanganan',
        'video_penanganan',
    ];

    public function rekamanPenanganan()
    {
        return $this->hasMany(RekamanPenanganan::class, 'penanganan_id');
    }
}
