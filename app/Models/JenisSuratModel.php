<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSuratModel extends Model
{
    use HasFactory;

    protected $table = 'jenis_surat_suara';
    protected $primaryKey = 'id_jenis_surat_suara'; 
    public $timestamps = false;
    protected $fillable = ['nama_jenis_surat_suara'];

}
