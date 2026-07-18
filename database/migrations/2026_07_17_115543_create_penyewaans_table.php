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
        Schema::create('penyewaans', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // Relasi ke tabel kendaraans
            $table->foreignId('kendaraan_id')
                  ->constrained('kendaraans')
                  ->onDelete('cascade');

            // Data penyewaan
            $table->date('tanggal_sewa');
            $table->integer('lama_sewa');

            $table->decimal('total_harga', 12, 2)->nullable();

            $table->enum('status', [
                'Pending',
                'Disetujui',
                'Ditolak',
                'Selesai'
            ])->default('Pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyewaans');
    }
};