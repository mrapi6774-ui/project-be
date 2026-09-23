<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Innovation extends Model
{
    use HasFactory;

    protected $fillable = [
        'opd_id',
        'nama_inovasi',
        'tahapan',
        'inisiator',
        'jenis_inovasi',
        'bentuk_inovasi',
        'rancangan_bangun',
        'tujuan',
        'manfaat',
        'hasil_inovasi',
        'tahun',
        'skor_inovasi',
        'status',
    ];

    // Hubungan relasi ke Model Opd
    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}