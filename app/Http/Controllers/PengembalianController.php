<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Barang;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    // method mencari data peminjaman berdasarkan NIM
    public function cari(Request $request)
    {
        $nim = $request->nim;

        $peminjaman = Peminjaman::where('nim', $nim)->get();

        $barangDipinjam = $peminjaman->map(function ($pinjam) {
            return [
                'jenis_barang' => $pinjam->jenis_barang,
                'total_barang' => $pinjam->total_barang,
            ];
        });

        return view('pengembalian', compact('nim', 'barangDipinjam'));
    }

    // method memproses pengembalian barang
    public function store(Request $request)
{
    $request->validate([
        'nim' => 'required|string|exists:peminjaman,nim',
        'nama_barang' => 'required|string',
        'total_barang' => 'required|integer|min:1',
        'tanggal_pengembalian' => 'required|date',
    ]);

    $nim = $request->nim;
    $namaBarang = $request->nama_barang;
    $totalBarang = $request->total_barang;
    $tanggalPengembalian = $request->tanggal_pengembalian;

    $peminjaman = Peminjaman::where('nim', $nim)
        ->where('jenis_barang', $namaBarang)
        ->first();

    // jika peminjaman tidak ditemukan
    if (!$peminjaman) {
        return back()->with('error', 'Peminjaman tidak ditemukan.');
    }

    // jika barang sudah dikembalikan
    $pengembalian = Pengembalian::where('peminjaman_id', $peminjaman->id)
        ->first();
    if ($pengembalian) {
        return back()->with('error', 'Barang sudah dikembalikan sebelumnya.');
    }

    // menypan pengembalian
    $pengembalian = Pengembalian::create([
        'nim' => $nim,
        'jenis_barang' => $namaBarang,
        'peminjaman_id' => $peminjaman->id,
        'jumlah' => $totalBarang,
        'tanggal_pengembalian' => $tanggalPengembalian,
    ]);

    // update stok barang yg dikembalikan
    $barang = Barang::where('nama_barang', $namaBarang)->first();
    if ($barang) {
        $barang->increaseQuantity($totalBarang);
    }

    return redirect()->route('pengembalian.cari', ['nim' => $nim])
        ->with('success', 'Barang berhasil dikembalikan!');
}

}
