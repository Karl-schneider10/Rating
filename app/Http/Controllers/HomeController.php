<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Rating;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $units = Unit::with('pelayanans')->get();
        $ratings = Rating::with(['unit', 'pelayanan', 'balasans.user'])
                    ->latest()
                    ->paginate(10);
        
        return view('home', compact('units', 'ratings'));
    }
}