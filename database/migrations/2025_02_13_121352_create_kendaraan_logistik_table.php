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
        Schema::create('kendaraan_logistik', function (Blueprint $table) {
            $table->id('id_kendaraan');
            $table->string('nama_kendaraan',100);
            $table->string('plat_nomor',100);
            $table->enum('status',['standby', 'beroperasi']);
            $table->string('foto',255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan_logistik');
    }
};
