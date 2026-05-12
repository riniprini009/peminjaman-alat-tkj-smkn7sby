<?php

namespace App\Models;

use App\Models\TipeAlat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisAlat extends Model
{
    use HasFactory;
    protected $table = 'jenis_alat';
    protected $primaryKey = 'id_jenis';
    protected $fillable = [
        'nama_jenis'
    ];

    public function tipeAlat(){
        return $this->hasMany(TipeAlat::class, 'id_jenis', 'id_jenis');
    } 
}
