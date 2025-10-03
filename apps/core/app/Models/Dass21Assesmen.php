<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dass21Assesmen extends Model
{
    use HasFactory;

    protected $table = 'dass21_assesmen';

    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'kategori',
    ];
}
