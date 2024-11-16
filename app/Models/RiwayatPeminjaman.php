<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPeminjaman extends Model
{
    protected $table = 'riwayat_peminjaman';

    protected $fillable = [
        'nama_mahasiswa',
        'nim',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
    ];
}
