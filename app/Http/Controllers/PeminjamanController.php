<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;

class PeminjamanController extends Controller
{
    public function show()
    {
        $data = Peminjaman::all();
        $dataBarang = Barang::all();
        return view('peminjaman', compact('data', 'dataBarang'));
    }

    public function search(Request $request)
    {
        $nim = $request->input('nim');

        // mengambil data peminjam dan barang yang dipinjam berdasarkan nim
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
            'tanggal_peminjaman' => 'required|date', // Ganti 'tanggal_pengajuan' menjadi 'tanggal_peminjaman'
        ]);

        // mencari barang
        $barang = Barang::where('nama_barang', $request->jenis_barang)->first();

        if ($barang && $barang->jumlah >= $request->total_barang) {
            // menyipan peminjaman
            Peminjaman::create($request->all());

            // mengurangi jumlah barang
            $barang->reduceQuantity($request->total_barang);

            return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil.');
        }

        return redirect()->route('peminjaman')->with('error', 'Stok barang tidak cukup.');
    }
}
