<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    // 1. Tampilkan Semua OPD (Public)
    public function index(Request $request)
    {
        $tahun = $request->query('tahun', date('Y'));

        $opds = Opd::withCount(['innovations' => function ($query) use ($tahun) {
            $query->where('tahun', $tahun)->where('status', 'disetujui');
        }])->get()->map(function ($opd) use ($tahun) {
            $totalSkor = $opd->innovations()
                ->where('tahun', $tahun)
                ->where('status', 'disetujui')
                ->sum('skor_inovasi');

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

    // 2. Tampilkan Detail 1 OPD (Public)
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

    // 3. Tambah OPD Baru (Protected - Admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_opd'  => 'required|string|unique:opds,kode_opd',
            'nama_opd'  => 'required|string',
            'alamat'    => 'nullable|string',
            'latitude'  => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        $opd = Opd::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data OPD berhasil ditambahkan',
            'data' => $opd
        ], 201);
    }

    // 4. Update Data OPD (Protected - Admin)
    public function update(Request $request, $id)
    {
        $opd = Opd::find($id);

        if (!$opd) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data OPD tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'kode_opd'  => 'required|string|unique:opds,kode_opd,' . $id,
            'nama_opd'  => 'required|string',
            'alamat'    => 'nullable|string',
            'latitude'  => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        $opd->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data OPD berhasil diperbarui',
            'data' => $opd
        ], 200);
    }

    // 5. Hapus OPD (Protected - Admin)
    public function destroy($id)
    {
        $opd = Opd::find($id);

        if (!$opd) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data OPD tidak ditemukan'
            ], 404);
        }

        $opd->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data OPD berhasil dihapus'
        ], 200);
    }
}