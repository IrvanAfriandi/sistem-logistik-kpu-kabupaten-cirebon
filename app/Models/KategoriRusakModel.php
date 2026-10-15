<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriRusakModel extends Model
{
    use HasFactory;

    protected $table = 'kategori_rusak';   
    protected $primaryKey = 'id_kategori_rusak'; 
    public $timestamps = false;
    protected $fillable = ['nama_kerusakan'];

}
