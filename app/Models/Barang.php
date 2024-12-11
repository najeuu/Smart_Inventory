<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs';

    protected $fillable = [
        'nama_barang',
        'jumlah',
        'lokasi',
        'kode_rfid',
    ];

    // Relasi dengan Peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'jenis_barang', 'nama_barang');
    }

    // Method untuk mengurangi jumlah barang
    public function reduceQuantity($quantity)
    {
        // Kurangi jumlah barang
        if ($this->jumlah >= $quantity) {
            $this->jumlah -= $quantity;
            $this->save();
            return true;
        }
        return false; // jika stok tidak cukup 
    }
}
