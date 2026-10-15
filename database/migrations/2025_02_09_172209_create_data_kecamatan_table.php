<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('data_kecamatan', function (Blueprint $table) {
            $table->id('id_kecamatan'); // Primary Key
            $table->string('nama_kecamatan', 255);
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_kecamatan');
    }
};

