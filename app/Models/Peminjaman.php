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
        'barang_id', 
        'total_barang',
        'tanggal_peminjaman'
    ];

    // relasi dengan Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'jenis_barang', 'nama_barang');
    }
    public function barangPinjam()
    {
        return $this->hasMany(Barang::class, 'peminjaman_id');
    }

    // relasi dengan Pengembalian
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }
}
