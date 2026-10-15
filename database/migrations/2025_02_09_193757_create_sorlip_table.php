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
        Schema::create('sorlip', function (Blueprint $table) {
            $table->id('id_sorlip');
            $table->unsignedBigInteger('id_box');
            $table->unsignedBigInteger('petugas')->nullable();
            $table->integer('isi_setelah_disorlip')->nullable();
            $table->string('waktu_dibuka', 100)->nullable();
            $table->string('dibuka_oleh', 100)->nullable();
            $table->string('waktu_selesai', 100)->nullable();
            $table->string('diselesaikan_oleh', 100)->nullable();
            
            $table->foreign('id_box')->references('id_box')->on('surat_suara')->onDelete('cascade');
            $table->foreign('petugas')->references('id_petugas')->on('petugas')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sorlip');
    }
};
