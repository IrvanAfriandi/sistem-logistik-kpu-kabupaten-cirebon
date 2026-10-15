<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataKecamatanModel extends Model
{
    use HasFactory;

    protected $table = 'data_kecamatan';
    protected $primaryKey = 'id_kecamatan';
    public $timestamps = false;
    protected $fillable = ['nama_kecamatan'];

    public function kebutuhanSuratSuara()
    {
        return $this->hasMany(KebutuhanSuratSuaraModel::class, 'id_kecamatan');
    }

    public function kebutuhanPerlengkapan()
    {
        return $this->hasMany(KebutuhanPerlengkapanModel::class, 'id_kecamatan');
    }
}



