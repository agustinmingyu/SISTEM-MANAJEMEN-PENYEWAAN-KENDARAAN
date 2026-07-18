<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraans';

    protected $fillable = [
        'nama',
        'merk',
        'plat_nomor',
        'tahun',
        'harga_sewa',
        'status',
    ];

    /**
     * Relasi ke tabel penyewaans
     */
    public function penyewaans()
    {
        return $this->hasMany(Penyewaan::class);
    }
}