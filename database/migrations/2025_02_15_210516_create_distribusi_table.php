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
        Schema::create('distribusi', function (Blueprint $table) {
            $table->id('id_distribusi');
            $table->unsignedBigInteger('id_kecamatan');
            $table->enum('status_kebutuhan_surat_suara', ['terpenuhi', 'belum_terpenuhi'])->default('belum_terpenuhi');
            $table->enum('status_kebutuhan_perlengkapan', ['terpenuhi', 'belum_terpenuhi'])->default('belum_terpenuhi');
            $table->enum('status_distribusi', ['belum_siap', 'dikirim', 'diterima'])->default('belum_siap');
            $table->unsignedBigInteger('id_kendaraan')->nullable();
            $table->unsignedBigInteger('id_driver')->nullable();

            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('data_kecamatan')->onDelete('cascade');
            $table->foreign('id_kendaraan')->references('id_kendaraan')->on('kendaraan_logistik')->onDelete('set null');
            $table->foreign('id_driver')->references('id_driver')->on('driver')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distribusi');
    }
};
