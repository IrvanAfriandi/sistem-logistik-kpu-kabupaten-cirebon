<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SorlipModel extends Model
{
    use HasFactory;
    protected $table = 'sorlip';
    protected $primaryKey = 'id_sorlip';
    public $timestamps = false;
    protected $fillable = ['id_box','petugas','isi_setelah_disorlip','waktu_dibuka','dibuka_oleh','waktu_selesai','diselesaikan_oleh'];
    
    public function box_id()
    {
        return $this->belongsTo(BoxModel::class, 'id_box', 'id_box');
    }
    public function petugas_id()
    {
        return $this->belongsTo(PetugasModel::class, 'petugas', 'id_petugas');
    }
}
