<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'nama_mahasiswa', 
        'nim', 
        'jenis_barang', 
        'total_barang', 
        'tanggal_pengajuan'
    ];

    // Relasi dengan Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'jenis_barang', 'nama_barang');
    }
    public function barangPinjam()
    {
        return $this->hasMany(Barang::class, 'peminjaman_id');  // Relasi dengan model Barang
    }

}
