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
        Schema::create('packing_box', function (Blueprint $table) {
            $table->id('id_packing_box');
            $table->unsignedBigInteger('id_box')->nullable();
            $table->string('mulai_packing_oleh', 100)->nullable();
            $table->string('waktu_mulai_packing', 100)->nullable();
            $table->string('selesai_packing_oleh', 100)->nullable();
            $table->string('waktu_selesai_packing', 100)->nullable();

            $table->foreign('id_box')->references('id_box')->on('surat_suara')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packing_box');
    }
};
