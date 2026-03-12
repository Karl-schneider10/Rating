<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'nama',
        'email',
        'unit_id',
        'pelayanan_id',
        'rating',
        'komentar'
    ];

    protected $casts = [
        'rating' => 'integer'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function pelayanan()
    {
        return $this->belongsTo(Pelayanan::class);
    }

    public function balasans()
    {
        return $this->hasMany(Balasan::class)->orderBy('created_at', 'asc');
    }
}