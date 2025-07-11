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
        'kategori_id',
        'deskripsi',
        'gambar',
        'lokasi_id',
        'kode_rfid',
    ];

    // relasi dengan Peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'jenis_barang', 'nama_barang');
    }

    // mengurangi jumlah barang dr peminjaman
    public function reduceQuantity($quantity)
    {
        if ($this->jumlah >= $quantity) {
            $this->jumlah -= $quantity;
            $this->save();
            return true;
        }
        return false;
    }

    public function increaseQuantity($quantity)
    {
        // menambah jumlah barang dr pengembalian
        $this->jumlah += $quantity;
        $this->save();
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }
}
