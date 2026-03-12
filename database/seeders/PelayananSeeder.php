<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelayanan;

class PelayananSeeder extends Seeder
{
    public function run(): void
    {
        $pelayanans = [
            // Keamanan (unit_id = 1)
            ['nama_pelayanan' => 'Pos Satpam', 'unit_id' => 1, 'deskripsi' => 'Pelayanan pos satpam'],
            ['nama_pelayanan' => 'Parkir', 'unit_id' => 1, 'deskripsi' => 'Pelayanan parkir kampus'],
            ['nama_pelayanan' => 'CCTV', 'unit_id' => 1, 'deskripsi' => 'Sistem keamanan CCTV'],
            ['nama_pelayanan' => 'Patroli', 'unit_id' => 1, 'deskripsi' => 'Patroli keamanan'],
            
            // Kebersihan (unit_id = 2)
            ['nama_pelayanan' => 'Kebersihan Ruang Kelas', 'unit_id' => 2, 'deskripsi' => 'Kebersihan ruang kelas'],
            ['nama_pelayanan' => 'Kebersihan Toilet', 'unit_id' => 2, 'deskripsi' => 'Kebersihan toilet'],
            ['nama_pelayanan' => 'Pengelolaan Sampah', 'unit_id' => 2, 'deskripsi' => 'Pengelolaan sampah'],
            
            // Akademik (unit_id = 3)
            ['nama_pelayanan' => 'Registrasi', 'unit_id' => 3, 'deskripsi' => 'Pelayanan registrasi mahasiswa'],
            ['nama_pelayanan' => 'Kartu Mahasiswa', 'unit_id' => 3, 'deskripsi' => 'Pembuatan KTM'],
            ['nama_pelayanan' => 'Transkrip Nilai', 'unit_id' => 3, 'deskripsi' => 'Pengambilan transkrip'],
            
            // Kemahasiswaan (unit_id = 4)
            ['nama_pelayanan' => 'Beasiswa', 'unit_id' => 4, 'deskripsi' => 'Informasi beasiswa'],
            ['nama_pelayanan' => 'Kegiatan Mahasiswa', 'unit_id' => 4, 'deskripsi' => 'Pelayanan kegiatan mahasiswa'],
            
            // Perpustakaan (unit_id = 5)
            ['nama_pelayanan' => 'Peminjaman Buku', 'unit_id' => 5, 'deskripsi' => 'Layanan peminjaman buku'],
            ['nama_pelayanan' => 'Ruang Baca', 'unit_id' => 5, 'deskripsi' => 'Layanan ruang baca'],
            
            // Fasilitas (unit_id = 6)
            ['nama_pelayanan' => 'Laboratorium', 'unit_id' => 6, 'deskripsi' => 'Fasilitas lab'],
            ['nama_pelayanan' => 'Wifi', 'unit_id' => 6, 'deskripsi' => 'Layanan wifi kampus'],
            ['nama_pelayanan' => 'Kantin', 'unit_id' => 6, 'deskripsi' => 'Fasilitas kantin'],
        ];

        foreach ($pelayanans as $pelayanan) {
            Pelayanan::create($pelayanan);
        }
    }
}