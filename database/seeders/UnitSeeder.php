<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['nama_unit' => 'Keamanan', 'deskripsi' => 'Unit keamanan kampus'],
            ['nama_unit' => 'Kebersihan', 'deskripsi' => 'Unit kebersihan lingkungan'],
            ['nama_unit' => 'Akademik', 'deskripsi' => 'Unit pelayanan akademik'],
            ['nama_unit' => 'Kemahasiswaan', 'deskripsi' => 'Unit pelayanan kemahasiswaan'],
            ['nama_unit' => 'Perpustakaan', 'deskripsi' => 'Unit pelayanan perpustakaan'],
            ['nama_unit' => 'Fasilitas', 'deskripsi' => 'Unit fasilitas kampus'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}