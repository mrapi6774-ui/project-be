<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_opd',
        'nama_opd',
        'alamat',
        'latitude',
        'longitude',
    ];

    // Tambahkan relasi ini
    public function innovations()
    {
        return $this->hasMany(Innovation::class);
    }
}