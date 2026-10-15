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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); 
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->enum('role', ['admin', 'ppk']);
            $table->string('nama', 255);
            $table->string('foto', 255)->nullable();
            $table->string('divisi', 255)->nullable();
            $table->string('jabatan', 255)->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->integer('umur')->nullable();
            $table->string('alamat', 255)->nullable();
            $table->bigInteger('no_telepon')->nullable();
            $table->tinyInteger('hak_pengawas')->default(0);
            $table->unsignedBigInteger('id_kecamatan')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_kecamatan')->references('id_kecamatan')->on('data_kecamatan')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
