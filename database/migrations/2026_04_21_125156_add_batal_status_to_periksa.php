<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('periksa', function (Blueprint $table) {
            DB::statement("ALTER TABLE periksa MODIFY COLUMN status_periksa ENUM('belum_saatnya', 'antri', 'sedang_periksa', 'menunggu_pembayaran', 'bagian_obat', 'selesai', 'batal') NOT NULL DEFAULT 'belum_saatnya'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('periksa', function (Blueprint $table) {
            DB::statement("ALTER TABLE periksa MODIFY COLUMN status_periksa ENUM('belum_saatnya', 'antri', 'sedang_periksa', 'menunggu_pembayaran', 'bagian_obat', 'selesai') NOT NULL DEFAULT 'belum_saatnya'");
        });
    }
};
