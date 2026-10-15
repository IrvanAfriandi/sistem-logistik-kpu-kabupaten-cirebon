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
        Schema::create('driver', function (Blueprint $table) {
            $table->id('id_driver');
            $table->string('nama_driver',100);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->integer('umur');
            $table->bigInteger('no_telepon');
            $table->string('alamat_driver',100);
            $table->enum('status',['standby', 'bekerja']);
            $table->string('foto',255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driver');
    }
};
