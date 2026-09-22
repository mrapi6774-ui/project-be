<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Models\Innovation;
use App\Models\Announcement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->query('tahun', date('Y'));

        // Hitung total OPD
        $totalOpd = Opd::count();

        // Hitung statistik skor inovasi berdasarkan kriteria
        $sangatInovatif = Innovation::where('tahun', $tahun)->where('skor_inovasi', '>=', 75)->count();
        $inovatif       = Innovation::where('tahun', $tahun)->whereBetween('skor_inovasi', [50, 74])->count();
        $kurangInovatif = Innovation::where('tahun', $tahun)->where('skor_inovasi', '<', 50)->count();

        // OPD yang belum ada input data inovasi di tahun terpilih
        $opdBelumInput  = $totalOpd - ($sangatInovatif + $inovatif + $kurangInovatif);

        // Pengumuman aktif
        $announcements = Announcement::where('is_active', true)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data dashboard berhasil diambil',
            'data' => [
                'statistik' => [
                    'sangat_inovatif' => $sangatInovatif,
                    'inovatif'        => $inovatif,
                    'kurang_inovatif' => $kurangInovatif,
                    'belum_input'     => $opdBelumInput,
                    'total_opd'       => $totalOpd,
                ],
                'pengumuman' => $announcements
            ]
        ], 200);
    }
}