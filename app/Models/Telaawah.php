<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telaawah extends Model
{
    protected $table = 'telaawat';

    protected $fillable = [
        'sheikh_id',
        'name',
        'audio_url',
        'description',
    ];

    public function sheikh()
    {
        return $this->belongsTo(Sheikh::class);
    }

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }
}
