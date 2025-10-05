<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dass21Item extends Model
{
    protected $fillable = ['kode','pernyataan','subskala','urutan'];

    public function responses()
    {
        return $this->hasMany(Dass21Response::class, 'dass21_item_id');
    }
}
