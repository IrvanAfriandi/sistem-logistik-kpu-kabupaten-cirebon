<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method bool isAdmin() Apakah user adalah admin
 * @method bool isPPK() Apakah user adalah PPK
 * @method bool isPengawas() Apakah user adalah pengawas
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    const ROLE_ADMIN = 'Admin';
    const ROLE_PPK = 'PPK';
    protected $fillable = [
        'email',
        'password',
        'role',
        'hak_pengawas',
        'nama',
        'jabatan',
        'foto',
        'divisi',
        'jabatan',
        'jenis_kelamin',
        'umur',
        'alamat',
        'no_telepon',
        'id_kecamatan',
    ];

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isPPK(): bool
    {
        return $this->role === self::ROLE_PPK;
    }

    public function isPengawas(): bool
    {
        return $this->is_pengawas;
    }

    public function kecamatan()
    {
        return $this->belongsTo(DataKecamatanModel::class, 'id_kecamatan', 'id_kecamatan');
    }

}
