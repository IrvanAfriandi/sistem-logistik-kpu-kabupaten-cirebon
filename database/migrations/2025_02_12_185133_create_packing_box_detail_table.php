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
        Schema::create('packing_box_detail', function (Blueprint $table) {
            $table->id('id_packing_box_detail');
            $table->unsignedBigInteger('id_packing_box');
            $table->unsignedBigInteger('kecamatan')->nullable();
            $table->integer('isi_dipakai')->nullable();
            $table->integer('sisa_isi_box')->nullable();

            $table->foreign('id_packing_box')->references('id_packing_box')->on('packing_box')->onDelete('cascade');
            $table->foreign('kecamatan')->references('id_kecamatan')->on('data_kecamatan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packing_box_detail');
    }
};
