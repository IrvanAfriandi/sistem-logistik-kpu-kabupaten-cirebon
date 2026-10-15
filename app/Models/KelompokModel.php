<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokModel extends Model
{
    use HasFactory;
    protected $table = 'kelompok'; 
    protected $primaryKey = 'id_kelompok';   
    public $timestamps = false;
    protected $fillable = ['nama_kelompok', 'pengawas'];

    public function pengawas_id()
    {
        return $this->belongsTo(User::class, 'pengawas','id');
    }
    public function petugas()
    {
        return $this->hasMany(PetugasModel::class, 'kelompok', 'id_kelompok');
    }



}
