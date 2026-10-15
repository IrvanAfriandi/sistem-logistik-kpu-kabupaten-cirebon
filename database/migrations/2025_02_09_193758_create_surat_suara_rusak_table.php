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
        Schema::create('surat_suara_rusak', function (Blueprint $table) {
            $table->id('id_surat_suara_rusak');
            $table->unsignedBigInteger('id_sorlip');
            $table->integer('jumlah_rusak')->nullable();
            $table->unsignedBigInteger('kategori_rusak')->nullable();

            $table->foreign('id_sorlip')->references('id_sorlip')->on('sorlip')->onDelete('cascade');
            $table->foreign('kategori_rusak')->references('id_kategori_rusak')->on('kategori_rusak')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_suara_rusak');
    }
};
