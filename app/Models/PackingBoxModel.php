<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingBoxModel extends Model
{
    use HasFactory;
    protected $table = 'packing_box';    
    protected $primaryKey = 'id_packing_box';   
    public $timestamps = false;
    protected $fillable = ['id_box','mulai_packing_oleh','waktu_mulai_packing','selesai_packing_oleh','waktu_selesai_packing'];

    public function box_id()
    {
        return $this->belongsTo(BoxModel::class, 'id_box','id_box');
    }
}

