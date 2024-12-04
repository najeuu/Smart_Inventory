<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'barangs';

    // Menentukan kolom yang dapat diisi secara massal
    protected $fillable = [
        'nama_barang',
        'jumlah',
        'lokasi',
        'kode_rfid',
    ];

}