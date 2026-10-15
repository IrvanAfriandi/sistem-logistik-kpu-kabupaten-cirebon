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
        Schema::create('perlengkapan', function (Blueprint $table) {
            $table->id('id_perlengkapan');
            $table->string('nama_perlengkapan', 100);
            $table->bigInteger('jumlah_tersimpan', 100);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perlengkapan');
    }
};
