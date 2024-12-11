<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;  // Import model Barang

class PeminjamanController extends Controller
{
    public function show()
    {
        $data = Peminjaman::all(); // Ambil data peminjaman
        $dataBarang = Barang::all(); // Ambil data barang
        return view('peminjaman', compact('data', 'dataBarang')); // Kirim data peminjaman dan barang ke view
    }
    public function search(Request $request)
    {
        $nim = $request->input('nim');

        // mengambil data peminjam dan barang yang dipinjam berdasarkan NIM
        $peminjam = Peminjaman::where('nim', $nim)->first();
        if (!$peminjam) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

        // mengambil data barang yang dipinjam
        $barang = Barang::where('peminjaman_id', $peminjam->id)->get();

        return response()->json([
            'peminjam' => $peminjam,
            'barang' => $barang
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'jenis_barang' => 'required|string|max:255',
            'total_barang' => 'required|integer',
            'tanggal_pengajuan' => 'required|date',
        ]);

        // Cari barang berdasarkan jenis_barang
        $barang = Barang::where('nama_barang', $request->jenis_barang)->first();

        // Cek apakah barang tersedia
        if ($barang && $barang->jumlah >= $request->total_barang) {
            // Simpan peminjaman
            Peminjaman::create($request->all());

            // Kurangi jumlah barang
            $barang->reduceQuantity($request->total_barang);

            return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil.');
        }

        // Jika stok barang tidak cukup
        return redirect()->route('peminjaman')->with('error', 'Stok barang tidak cukup.');
    }
}
