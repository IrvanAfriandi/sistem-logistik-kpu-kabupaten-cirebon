<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebutuhanPerlengkapanModel extends Model
{
    use HasFactory;
    protected $table = 'data_kebutuhan_perlengkapan';    
    public $timestamps = false;
    protected $fillable = ['id_kecamatan','id_perlengkapan','jumlah_kebutuhan_perlengkapan','jumlah_perlengkapan_terpenuhi'];

    public function kecamatan_id()
    {
        return $this->belongsTo(DataKecamatanModel::class, 'id_kecamatan','id_kecamatan');
    }
    public function perlengkapan_id()
    {
        return $this->belongsTo(PerlengkapanModel::class, 'id_perlengkapan','id_perlengkapan');
    }
}
