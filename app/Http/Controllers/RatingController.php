<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Unit;
use App\Models\Pelayanan;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'unit_id' => 'required|exists:units,id',
            'pelayanan_id' => 'required|exists:pelayanans,id',
            'rating' => 'required|integer|min:1|max:4',
            'komentar' => 'required|string',
        ]);

        Rating::create($request->all());

        return redirect()->route('home')->with('success', 'Rating berhasil dikirim!');
    }

    public function getPelayanan($unitId)
    {
        $pelayanans = Pelayanan::where('unit_id', $unitId)->get();
        return response()->json($pelayanans);
    }
}