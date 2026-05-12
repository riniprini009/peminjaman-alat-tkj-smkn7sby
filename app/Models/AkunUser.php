<?php

namespace App\Models;

use App\Models\Siswa;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AkunUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'akun_user';
    protected $primaryKey = 'id_akun_user';
    protected $fillable = [
        'username',
        'password',
        'role',
        'status_akun',
        'fcm_token'
    ];

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'id_akun_user', 'id_akun_user');
    }
}
