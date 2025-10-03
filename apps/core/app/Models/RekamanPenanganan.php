<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamanPenanganan extends Model
{
    use HasFactory;

    protected $table = 'rekaman_penanganan';

    protected $fillable = [
        'analisis_id',
        'jenis_penanganan',
        'penanganan_id',
        'konsultan_id',
    ];

    public function analisis()
    {
        return $this->belongsTo(Analisis::class, 'analisis_id');
    }

    public function penanganan()
    {
        return $this->belongsTo(Penanganan::class, 'penanganan_id');
    }

    public function konsultan()
    {
        return $this->belongsTo(Konsultan::class, 'konsultan_id');
    }
}
