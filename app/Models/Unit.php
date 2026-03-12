<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['nama_unit', 'deskripsi'];

    public function pelayanans()
    {
        return $this->hasMany(Pelayanan::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}