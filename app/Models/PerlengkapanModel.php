<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerlengkapanModel extends Model
{
    use HasFactory;
    protected $table = 'perlengkapan'; 
    protected $primaryKey = 'id_perlengkapan';   
    public $timestamps = false;
    protected $fillable = ['nama_perlengkapan', 'jumlah_tersimpan'];
}
