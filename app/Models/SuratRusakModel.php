<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratRusakModel extends Model
{
    use HasFactory;
    protected $table = 'surat_suara_rusak';    
    protected $primaryKey = 'id_surat_suara_rusak'; 
    public $timestamps = false;
    protected $fillable = ['id_sorlip','jumlah_rusak','kategori_rusak'];

    public function rusak_kategori()
    {
        return $this->belongsTo(KategoriRusakModel::class, 'kategori_rusak', 'id_kategori_rusak');
    }
    public function id_sorlip_rusak()
    {
        return $this->belongsTo(SorlipModel::class, 'id_sorlip', 'id_sorlip');
    }
}
