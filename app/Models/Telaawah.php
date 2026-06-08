<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telaawah extends Model
{
    protected $table = 'telaawat';

    public function sheikh()
    {
        return $this->belongsTo(Sheikh::class);
    }

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }
}