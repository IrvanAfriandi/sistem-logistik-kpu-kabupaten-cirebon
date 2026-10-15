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
        Schema::create('data_kebutuhan_surat_suara', function (Blueprint $table) {
            $table->id('id_kebutuhan_surat_suara');
            $table->unsignedBigInteger('id_kecamatan');
            $table->unsignedBigInteger('id_jenis_surat_suara')->nullable();
            $table->integer('jumlah_kebutuhan_surat_suara');
            $table->integer('jumlah_surat_suara_terpenuhi');

            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('data_kecamatan')->onDelete('cascade');
            $table->foreign('id_jenis_surat_suara')->references('id_jenis_surat_suara')->on('jenis_surat_suara')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kebutuhan_surat_suara');
    }
};
