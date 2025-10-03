<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dass21User extends Model
{
    use HasFactory;

    protected $table = 'dass21_user';

    protected $fillable = [
        'user_id',
        'anxiety_skor',
        'depresi_skor',
        'stres_skor',
        'total_skor',
        'anxiety_kelas',
        'depresi_kelas',
        'stres_kelas',
        'hasil_kelas',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suara()
    {
        return $this->hasMany(Suara::class, 'dass21_user_id');
    }
}
