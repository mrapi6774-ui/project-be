<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Opd;
use App\Models\Innovation;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data OPD Contoh
        $bapperida = Opd::create([
            'nama_opd'  => 'Bapperida',
            'kode_opd'  => 'OPD-01',
            'alamat'    => 'Jl. Rasakunda No.1, Pangkalpinang',
            'latitude'  => -2.12870000,
            'longitude' => 106.10900000,
        ]);

        $dinkes = Opd::create([
            'nama_opd'  => 'Dinas Kesehatan',
            'kode_opd'  => 'OPD-02',
            'alamat'    => 'Jl. Sudirman No.12, Pangkalpinang',
            'latitude'  => -2.13200000,
            'longitude' => 106.11500000,
        ]);

        // 2. Buat Data Inovasi
        Innovation::create([
            'opd_id'           => $bapperida->id,
            'nama_inovasi'     => 'Sistem Perencanaan Terpadu',
            'tahapan'          => 'penerapan',
            'inisiator'        => 'OPD',
            'jenis_inovasi'    => 'digital',
            'bentuk_inovasi'   => 'inovasi tata kelola pemerintahan',
            'rancangan_bangun' => 'Rancangan sistem terpadu untuk efisiensi perencanaan daerah.',
            'tujuan'           => 'Meningkatkan transparansi dan kecepatan perencanaan.',
            'manfaat'          => 'Memudahkan koordinasi antar bidang.',
            'hasil_inovasi'    => 'Waktu penyusunan perencanaan terpotong hingga 50%.',
            'tahun'            => '2024',
            'skor_inovasi'     => 85,
            'status'           => 'disetujui',
        ]);

        Innovation::create([
            'opd_id'           => $dinkes->id,
            'nama_inovasi'     => 'Layanan Ambulans Cepat',
            'tahapan'          => 'penerapan',
            'inisiator'        => 'OPD',
            'jenis_inovasi'    => 'non-digital',
            'bentuk_inovasi'   => 'inovasi pelayanan publik',
            'rancangan_bangun' => 'Layanan pemanggilan ambulans darurat 24 jam.',
            'tujuan'           => 'Memberikan pertolongan medis darurat secara cepat.',
            'manfaat'          => 'Meningkatkan respon penanganan pasien kritis.',
            'hasil_inovasi'    => 'Waktu kedatangan ambulans kurang dari 15 menit.',
            'tahun'            => '2024',
            'skor_inovasi'     => 60,
            'status'           => 'disetujui',
        ]);

        // 3. Buat Data Pengumuman
        Announcement::create([
            'judul'          => 'Penginputan Inovasi OPD',
            'isi_pengumuman' => 'Diberitahukan kepada operator bahwa penginputan inovasi OPD diperpanjang.',
            'is_active'      => true,
        ]);

        // 4. Buat User Operator
        User::create([
            'opd_id'   => $bapperida->id,
            'name'     => 'Operator Bapperida',
            'email'    => 'operator.bapperida@pangkalpinangkota.go.id',
            'password' => Hash::make('password123'),
            'role'     => 'operator_opd',
        ]);
    }
}