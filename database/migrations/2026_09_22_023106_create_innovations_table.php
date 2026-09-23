<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('innovations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_id')->constrained('opds')->onDelete('cascade');
            $table->string('nama_inovasi');
            $table->string('tahapan');
            $table->string('inisiator');
            $table->string('jenis_inovasi');
            $table->string('bentuk_inovasi');
            $table->text('rancangan_bangun');
            $table->text('tujuan')->nullable();
            $table->text('manfaat')->nullable();
            $table->text('hasil_inovasi')->nullable();
            $table->string('tahun');
            $table->decimal('skor_inovasi', 8, 2)->default(0);
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('innovations');
    }
};