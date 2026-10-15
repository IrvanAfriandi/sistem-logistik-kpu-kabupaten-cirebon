<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanLogistikModel extends Model
{
    use HasFactory;
    protected $table = 'kendaraan_logistik'; 
    protected $primaryKey = 'id_kendaraan';    
    public $timestamps = false;
    protected $fillable = ['nama_kendaraan','plat_nomor','foto'];

}

