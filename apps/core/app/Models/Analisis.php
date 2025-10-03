<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analisis extends Model
{
    use HasFactory;

    protected $table = 'analisis';

    protected $fillable = [
        'user_id',
        'dass21_user_id',
        'suara_id',
        'hasil_kondisi',
        'hasil_emosi',
        'ringkasan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dass21User()
    {
        return $this->belongsTo(Dass21User::class, 'dass21_user_id');
    }

    public function suara()
    {
        return $this->belongsTo(Suara::class, 'suara_id');
    }
}
