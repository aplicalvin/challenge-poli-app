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
        // Tabel Jadwal Jaga
        Schema::create('jadwal_jaga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_shift')->constrained('shift');
            $table->foreignId('id_dokter')->constrained('dokter');
            $table->foreignId('id_ruang')->constrained('ruang');
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
        Schema::dropIfExists('jadwal_jaga');
    }
};
