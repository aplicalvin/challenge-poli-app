<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel Periksa (Pendaftaran & Hasil) 
        Schema::create('periksa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pasien')->constrained('pasien');
            $table->foreignId('id_jadwal_jaga')->constrained('jadwal_jaga');
            $table->text('keluhan'); // 
            $table->integer('no_antrian');
            $table->string('nama_penyakit')->nullable();
            $table->text('catatan')->nullable(); // 
            $table->dateTime('tgl_periksa')->nullable();
            $table->integer('biaya_periksa')->nullable(); // 
            $table->enum('status_periksa', [
                'belum_saatnya',
                'antri',
                'sedang_periksa',
                'menunggu_pembayaran',
                'bagian_obat',
                'selesai'
            ])->default('belum_saatnya');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('edited_by')->nullable();
            $table->timestamps();

            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('edited_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periksa');
    }
};
