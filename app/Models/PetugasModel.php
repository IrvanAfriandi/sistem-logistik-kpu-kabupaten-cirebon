<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetugasModel extends Model
{
    use HasFactory;
    protected $table = 'petugas'; 
    protected $primaryKey = 'id_petugas';   
    public $timestamps = false;
    protected $fillable = ['nama','jenis_kelamin','umur','alamat','telepon','nik','kelompok','foto'];

    public function kelompok_sorlip()
    {
        return $this->belongsTo(KelompokModel::class, 'kelompok', 'id_kelompok');
    }
}
