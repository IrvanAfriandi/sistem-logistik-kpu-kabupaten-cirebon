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
        Schema::create('data_kebutuhan_perlengkapan', function (Blueprint $table) {
            $table->id('id_kebutuhan_perlengkapan');
            $table->unsignedBigInteger('id_kecamatan');
            $table->unsignedBigInteger('id_perlengkapan')->nullable();
            $table->integer('jumlah_kebutuhan_perlengkapan');
            $table->integer('jumlah_perlengkapan_terpenuhi');

            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('data_kecamatan')->onDelete('cascade');
            $table->foreign('id_perlengkapan')->references('id_perlengkapan')->on('perlengkapan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_kebutuhan_perlengkapan');
    }
};
