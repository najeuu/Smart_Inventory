<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'kode_rfid',
        'barang_id',
        'total_barang',
        'tanggal_peminjaman',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }

    public function pengembalians()
    {
        return $this->hasMany(Pengembalian::class, 'peminjaman_id');
    }
    public function getJumlahDikembalikanAttribute()
    {
        return $this->pengembalians->sum('jumlah');
    }

    public function getTanggalPengembalianTerakhirAttribute()
    {
        return $this->pengembalians->last()?->tanggal_pengembalian;
    }
}
