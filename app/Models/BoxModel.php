<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoxModel extends Model
{
    use HasFactory;
    protected $table = 'surat_suara'; 
    protected $primaryKey = 'id_box';   
    public $timestamps = false;
    protected $fillable = ['nomor_box','jenis','isi_awal','status_box','ditambahkan_oleh','waktu_ditambahkan','waktu_terakhir_diedit','terakhir_diedit_oleh'];

    public function jenis_surat()
    {
        return $this->belongsTo(JenisSuratModel::class, 'jenis', 'id_jenis_surat_suara');
    }

    
}


