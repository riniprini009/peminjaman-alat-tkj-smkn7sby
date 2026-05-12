<?php

namespace App\Models;

use App\Models\DetailAlat;
use App\Models\JenisAlat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TipeAlat extends Model
{
    use HasFactory;
    protected $table = 'tipe_alat';
    protected $primaryKey = 'id_tipe';
    protected $fillable = [
        'id_jenis',
        'nama_tipe',
        'stok',
        'lokasi_rak',
        'gambar'
    ];

    public function jenisAlat()
    {
        return $this->belongsTo(JenisAlat::class, 'id_jenis', 'id_jenis');
    }

    public function detailAlat()
    {
        return $this->hasMany(DetailAlat::class, 'id_tipe', 'id_tipe');
    }

    public function peminjaman()
    {
        return $this->belongsToMany(Peminjaman::class, 'peminjaman_tipe', 'id_tipe', 'id_pinjam')->withPivot('quantity')->withTimestamps();
    }

   
}
