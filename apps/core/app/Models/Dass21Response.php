<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dass21Response extends Model
{
    protected $fillable = ['dass21_session_id','dass21_item_id','nilai'];

    public function session()
    {
        return $this->belongsTo(Dass21Session::class, 'dass21_session_id');
    }

    public function item()
    {
        return $this->belongsTo(Dass21Item::class, 'dass21_item_id');
    }
}
