<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PackingBoxDetailModel extends Model
{
    use HasFactory;
    protected $table = 'packing_box_detail'; 
    protected $primaryKey = 'id_packing_box_detail';  
    public $timestamps = false;
    protected $fillable = ['id_packing_box','kecamatan','isi_dipakai','sisa_isi_box'];
    
    public function packing_id()
    {
        return $this->belongsTo(PackingBoxModel::class, 'id_packing','id_packing');
    }
    public function kecamatan_id()
    {
        return $this->belongsTo(DataKecamatanModel::class, 'kecamatan','id_kecamatan');
    }
}