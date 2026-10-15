<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebutuhanSuratSuaraModel extends Model
{
    use HasFactory;
    protected $table = 'data_kebutuhan_surat_suara';    
    public $timestamps = false;
    protected $fillable = ['id_kecamatan','id_jenis_surat_suara','jumlah_kebutuhan_surat_suara','jumlah_surat_suara_terpenuhi'];

    public function kecamatan_id()
    {
        return $this->belongsTo(DataKecamatanModel::class, 'id_kecamatan','id_kecamatan');
    }
    public function jenis_surat_suara_id()
    {
        return $this->belongsTo(JenisSuratModel::class, 'id_jenis_surat_suara','id_jenis_surat_suara');
    }
}

