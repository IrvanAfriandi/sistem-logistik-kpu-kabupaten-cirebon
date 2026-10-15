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
        Schema::create('surat_suara', function (Blueprint $table) {
            $table->id('id_box');
            $table->string('nomor_box',100);
            $table->unsignedBigInteger('jenis')->nullable();
            $table->integer('isi_awal');
            $table->integer('status_box')->nullable();
            $table->string('ditambahkan_oleh', 100);
            $table->string('waktu_ditambahkan', 100);
            $table->string('waktu_terakhir_diedit', 100);
             
            $table->unique(['nomor_box', 'jenis']);
            $table->foreign('jenis')->references('id_jenis_surat_suara')->on('jenis_surat_suara')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_suara');
    }
};
