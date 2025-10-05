<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dass21Session extends Model
{
    protected $fillable = [
        'user_id','depresi_raw','anxiety_raw','stres_raw',
        'depresi_skor','anxiety_skor','stres_skor','total_skor',
        'depresi_kelas','anxiety_kelas','stres_kelas','hasil_kelas',
        'overall_risk','overall_risk_note','completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function responses()
    {
        return $this->hasMany(Dass21Response::class, 'dass21_session_id');
    }

    public function analyses()
    {
        return $this->hasMany(Analisis::class, 'dass21_session_id');
    }

    public function suara()
    {
        return $this->hasMany(Suara::class, 'dass21_session_id');
    }
}
