<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
    protected $fillable = ['nama_pelayanan', 'unit_id', 'deskripsi'];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}