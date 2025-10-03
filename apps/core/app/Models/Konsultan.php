<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultan extends Model
{
    use HasFactory;

    protected $table = 'konsultan';

    protected $fillable = [
        'nama_konsultan',
        'spesialisasi',
        'jadwal_praktik',
        'harga',
        'rating',
    ];

    public function rekamanPenanganan()
    {
        return $this->hasMany(RekamanPenanganan::class, 'konsultan_id');
    }
}
