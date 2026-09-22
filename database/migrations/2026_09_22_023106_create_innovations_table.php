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
            $table->string('judul_inovasi');
            $table->text('deskripsi')->nullable();
            $table->string('jenis_inovasi')->default('Digital'); // Digital / Non-Digital
            $table->year('tahun');
            $table->integer('skor_inovasi')->default(0); // 0 - 100
            $table->enum('status', ['draft', 'diproses', 'disetujui'])->default('draft');
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
