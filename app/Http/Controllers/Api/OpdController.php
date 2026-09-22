<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    public function index(Request $request)
    {
        // Filter berdasarkan tahun jika ada parameter 'tahun' di URL, default tahun berjalan
        $tahun = $request->query('tahun', date('Y'));

        $opds = Opd::withCount(['innovations' => function ($query) use ($tahun) {
            $query->where('tahun', $tahun)->where('status', 'disetujui');
        }])->get()->map(function ($opd) use ($tahun) {
            // Hitung total skor inovasi OPD untuk tahun yang dipilih
            $totalSkor = $opd->innovations()
                ->where('tahun', $tahun)
                ->where('status', 'disetujui')
                ->sum('skor_inovasi');

            // Tentukan kategori predikat berdasarkan total skor
            $kategori = 'Belum Menginput';
            if ($totalSkor >= 100) {
                $kategori = 'Sangat Inovatif';
            } elseif ($totalSkor >= 50) {
                $kategori = 'Inovatif';
            } elseif ($totalSkor > 0) {
                $kategori = 'Kurang Inovatif';
            }

            return [
                'id' => $opd->id,
                'kode_opd' => $opd->kode_opd,
                'nama_opd' => $opd->nama_opd,
                'alamat' => $opd->alamat,
                'latitude' => $opd->latitude,
                'longitude' => $opd->longitude,
                'total_inovasi' => $opd->innovations_count,
                'total_skor' => $totalSkor,
                'kategori' => $kategori,
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Data OPD dan peta berhasil diambil',
            'tahun' => (int) $tahun,
            'data' => $opds
        ], 200);
    }

    public function show($id)
    {
        $opd = Opd::with(['innovations' => function ($query) {
            $query->where('status', 'disetujui');
        }])->find($id);

        if (!$opd) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data OPD tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail OPD berhasil diambil',
            'data' => $opd
        ], 200);
    }
}