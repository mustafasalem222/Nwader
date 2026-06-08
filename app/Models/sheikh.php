<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sheikh extends Model
{
    public function telaawat()
    {
        return $this->hasMany(Telaawah::class);
    }

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favouritable');
    }
}