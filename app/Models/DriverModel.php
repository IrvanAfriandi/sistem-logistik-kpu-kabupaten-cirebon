<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverModel extends Model
{
    use HasFactory;
    protected $table = 'driver';    
    protected $primaryKey = 'id_driver'; 
    public $timestamps = false;
    protected $fillable = ['nama_driver','jenis_kelamin','umur','no_telepon','alamat_driver','foto'];

}

