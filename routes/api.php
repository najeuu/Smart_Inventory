<?php

use Illuminate\Support\Facades\Route;
use App\Models\Barang;

Route::get('/barang/rfid/{kode}', function ($kode) {
    // Cek apakah barang ditemukan berdasarkan kode RFID
    $barang = Barang::where('kode_rfid', $kode)->first();

    if (!$barang) {
        return response()->json([
            'status' => false,
            'message' => 'Barang dengan kode RFID ini belum terdaftar.'
        ], 404);
    }

    // Jika ingin menambahkan pengecekan ketersediaan di masa depan
    // misalnya: if ($barang->jumlah < 1) { ... }

    return response()->json([
        'status' => true,
        'data' => [
            'nama_barang' => $barang->nama_barang,
            'jumlah' => $barang->jumlah,
            'lokasi' => $barang->lokasi->nama_lokasi ?? null,
            'kategori' => $barang->kategori->nama_kategori ?? null
        ]
    ]);
});
