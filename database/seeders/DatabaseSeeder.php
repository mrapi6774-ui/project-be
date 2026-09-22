<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Opd;
use App\Models\Innovation;
use App\Models\Announcement;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data OPD Contoh
        $bapperida = Opd::create([
            'nama_opd' => 'Bapperida',
            'kode_opd' => 'OPD-01',
            'alamat' => 'Jl. Rasakunda No.1, Pangkalpinang',
            'latitude' => -2.12870000,
            'longitude' => 106.10900000,
        ]);

        $dinkes = Opd::create([
            'nama_opd' => 'Dinas Kesehatan',
            'kode_opd' => 'OPD-02',
            'alamat' => 'Jl. Sudirman No.12, Pangkalpinang',
            'latitude' => -2.13200000,
            'longitude' => 106.11500000,
        ]);

        // 2. Buat Data Inovasi (Untuk tes hitung skor)
        Innovation::create([
            'opd_id' => $bapperida->id,
            'judul_inovasi' => 'Sistem Perencanaan Terpadu',
            'jenis_inovasi' => 'Digital',
            'tahun' => 2024,
            'skor_inovasi' => 85, // Sangat Inovatif (>= 75)
            'status' => 'disetujui'
        ]);

        Innovation::create([
            'opd_id' => $dinkes->id,
            'judul_inovasi' => 'Layanan Ambulans Cepat',
            'jenis_inovasi' => 'Non-Digital',
            'tahun' => 2024,
            'skor_inovasi' => 60, // Inovatif (50 - 74)
            'status' => 'disetujui'
        ]);

        // 3. Buat Data Pengumuman
        Announcement::create([
            'judul' => 'Penginputan Inovasi OPD',
            'isi_pengumuman' => 'Diberitahukan kepada operator bahwa penginputan inovasi OPD diperpanjang.',
            'is_active' => true
        ]);
    }
}