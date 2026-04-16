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
        // Tabel Pembayaran 
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_periksa')->constrained('periksa');
            $table->integer('total_bayar');
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status_pembayaran', ['pending', 'lunas'])->default('pending');
            $table->dateTime('tgl_bayar')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->unsignedBigInteger('added_by')->nullable();
            $table->unsignedBigInteger('edited_by')->nullable();
            $table->timestamps();

            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('edited_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
