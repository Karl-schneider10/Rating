<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Unit;
use App\Models\Pelayanan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalRatings = Rating::count();
        $averageRating = Rating::avg('rating');
        $ratings = Rating::with(['unit', 'pelayanan', 'balasans'])->latest()->paginate(10);
        
        // Hitung distribusi rating untuk statistik
        $ratingCounts = [
            4 => $ratings->where('rating', 4)->count(),
            3 => $ratings->where('rating', 3)->count(),
            2 => $ratings->where('rating', 2)->count(),
            1 => $ratings->where('rating', 1)->count(),
        ];
        
        // Cari rating tertinggi (bintang dengan jumlah terbanyak)
        $highestRating = 0;
        $highestRatingCount = 0;
        foreach([4,3,2,1] as $star) {
            if(($ratingCounts[$star] ?? 0) > $highestRatingCount) {
                $highestRatingCount = $ratingCounts[$star];
                $highestRating = $star;
            }
        }
        
        $totalUnits = Unit::count();
        
        return view('admin.dashboard', compact(
            'totalRatings', 
            'averageRating', 
            'ratings',
            'ratingCounts',
            'highestRating',
            'highestRatingCount',
            'totalUnits'
        ));
    }

    public function balas(Request $request, Rating $rating)
    {
        $request->validate([
            'balasan' => 'required|string',
        ]);

        $rating->balasans()->create([
            'user_id' => auth()->id(),
            'balasan' => $request->balasan,
        ]);

        return back()->with('success', 'Balasan berhasil dikirim!');
    }

    public function units()
    {
        $units = Unit::with('pelayanans')->get();
        return view('admin.units', compact('units'));
    }

    public function storeUnit(Request $request)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Unit::create($request->all());

        return redirect()->route('admin.units')->with('success', 'Unit berhasil ditambahkan!');
    }

    public function updateUnit(Request $request, Unit $unit)
    {
        $request->validate([
            'nama_unit' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $unit->update($request->all());

        return redirect()->route('admin.units')->with('success', 'Unit berhasil diupdate!');
    }

    public function deleteUnit(Unit $unit)
    {
        // Cek apakah unit memiliki pelayanan
        if($unit->pelayanans()->count() > 0) {
            return back()->with('error', 'Unit tidak dapat dihapus karena masih memiliki pelayanan!');
        }
        
        // Cek apakah unit memiliki rating
        if($unit->ratings()->count() > 0) {
            return back()->with('error', 'Unit tidak dapat dihapus karena masih memiliki rating!');
        }
        
        $unit->delete();
        return redirect()->route('admin.units')->with('success', 'Unit berhasil dihapus!');
    }

    public function storePelayanan(Request $request)
    {
        $request->validate([
            'nama_pelayanan' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'deskripsi' => 'nullable|string',
        ]);

        Pelayanan::create($request->all());

        return redirect()->route('admin.units')->with('success', 'Pelayanan berhasil ditambahkan!');
    }

    public function updatePelayanan(Request $request, Pelayanan $pelayanan)
    {
        $request->validate([
            'nama_pelayanan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $pelayanan->update($request->all());

        return redirect()->route('admin.units')->with('success', 'Pelayanan berhasil diupdate!');
    }

    public function deletePelayanan(Pelayanan $pelayanan)
    {
        // Cek apakah pelayanan memiliki rating
        if($pelayanan->ratings()->count() > 0) {
            return back()->with('error', 'Pelayanan tidak dapat dihapus karena masih memiliki rating!');
        }
        
        $pelayanan->delete();
        return redirect()->route('admin.units')->with('success', 'Pelayanan berhasil dihapus!');
    }

    /**
     * Get rating statistics for dashboard (API)
     */
    public function getStatistics()
    {
        $totalRatings = Rating::count();
        $averageRating = Rating::avg('rating');
        $ratingsPerUnit = Unit::withCount('ratings')->get();
        
        return response()->json([
            'total_ratings' => $totalRatings,
            'average_rating' => number_format($averageRating, 1),
            'ratings_per_unit' => $ratingsPerUnit
        ]);
    }
}