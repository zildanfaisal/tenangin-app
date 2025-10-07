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
        'slug',
        'deskripsi_penanganan',
        'tahapan_penanganan',
        'tutorial_penanganan',
        'video_penanganan',
        'status',
        'durasi_detik',
        'cover_path',
        'tingkat_kesulitan',
        'ordering',
    ];

    protected static function booted()
    {
        static::creating(function($model){
            if (!$model->slug) {
                $base = str()->slug($model->nama_penanganan);
                $candidate = $base;
                $i = 1;
                while (static::where('slug',$candidate)->exists()) {
                    $candidate = $base.'-'.$i++;
                }
                $model->slug = $candidate;
            }
        });
    }

    public function scopePublished($q)
    {
        return $q->where('status','published');
    }

    public function rekamanPenanganan()
    {
        return $this->hasMany(RekamanPenanganan::class, 'penanganan_id');
    }

    public function steps()
    {
        return $this->hasMany(\App\Models\PenangananStep::class,'penanganan_id')->orderBy('urutan');
    }
}
