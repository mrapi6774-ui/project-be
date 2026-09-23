<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Innovation;
use Illuminate\Http\Request;

class InnovationController extends Controller
{
    // 1. Tampilkan Semua Inovasi (Bisa difilter tahun, opd_id, status)
    public function index(Request $request)
    {
        $query = Innovation::with('opd');

        if ($request->has('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->has('opd_id')) {
            $query->where('opd_id', $request->opd_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $innovations = $query->latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Daftar inovasi berhasil diambil',
            'data' => $innovations
        ], 200);
    }

    // 2. Detail Inovasi
    public function show($id)
    {
        $innovation = Innovation::with('opd')->find($id);

        if (!$innovation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data inovasi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Detail inovasi berhasil diambil',
            'data' => $innovation
        ], 200);
    }

    // 3. Tambah Inovasi Baru (Operator OPD)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'opd_id'           => 'required|exists:opds,id',
            'nama_inovasi'     => 'required|string|max:255',
            'tahapan'          => 'required|string',
            'inisiator'        => 'required|string',
            'jenis_inovasi'    => 'required|string',
            'bentuk_inovasi'   => 'required|string',
            'rancangan_bangun' => 'required|string',
            'tujuan'           => 'nullable|string',
            'manfaat'          => 'nullable|string',
            'hasil_inovasi'    => 'nullable|string',
            'tahun'            => 'required|digits:4',
        ]);

        // Default status saat diajukan adalah 'pending' & skor awal 0
        $validated['status'] = 'pending';
        $validated['skor_inovasi'] = 0;

        $innovation = Innovation::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Inovasi berhasil diajukan',
            'data' => $innovation
        ], 201);
    }

    // 4. Update Inovasi / Penilaian Admin (Ubah status & skor)
    public function update(Request $request, $id)
    {
        $innovation = Innovation::find($id);

        if (!$innovation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data inovasi tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'nama_inovasi'     => 'sometimes|required|string|max:255',
            'tahapan'          => 'sometimes|required|string',
            'inisiator'        => 'sometimes|required|string',
            'jenis_inovasi'    => 'sometimes|required|string',
            'bentuk_inovasi'   => 'sometimes|required|string',
            'rancangan_bangun' => 'sometimes|required|string',
            'tujuan'           => 'nullable|string',
            'manfaat'          => 'nullable|string',
            'hasil_inovasi'    => 'nullable|string',
            'tahun'            => 'sometimes|required|digits:4',
            'skor_inovasi'     => 'nullable|numeric',
            'status'           => 'nullable|in:pending,disetujui,ditolak',
        ]);

        $innovation->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Data inovasi berhasil diperbarui',
            'data' => $innovation
        ], 200);
    }

    // 5. Hapus Inovasi
    public function destroy($id)
    {
        $innovation = Innovation::find($id);

        if (!$innovation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data inovasi tidak ditemukan'
            ], 404);
        }

        $innovation->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data inovasi berhasil dihapus'
        ], 200);
    }
}