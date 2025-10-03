<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suara extends Model
{
    use HasFactory;

    protected $table = 'suara';

    protected $fillable = [
        'user_id',
        'dass21_user_id',
        'file_audio',
        'transkripsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dass21User()
    {
        return $this->belongsTo(Dass21User::class, 'dass21_user_id');
    }
}
