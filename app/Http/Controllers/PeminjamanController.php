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
        $peminjam = Peminjaman::where('nim', $nim)->first();

        if (!$peminjam) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }

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
            'tanggal_peminjaman' => 'required|date',
        ]);

        // Find the barang based on nama_barang
        $barang = Barang::where('nama_barang', $request->jenis_barang)->first();

        if (!$barang) {
            return redirect()->route('peminjaman')->with('error', 'Barang tidak ditemukan.');
        }

        if ($barang->jumlah < $request->total_barang) {
            return redirect()->route('peminjaman')->with('error', 'Stok barang tidak cukup.');
        }

        try {
            // Create peminjaman with barang_id
            $peminjaman = Peminjaman::create([
                'nama_mahasiswa' => $request->nama_mahasiswa,
                'nim' => $request->nim,
                'jenis_barang' => $request->jenis_barang,
                'barang_id' => $barang->id, // Add the barang_id
                'total_barang' => $request->total_barang,
                'tanggal_peminjaman' => $request->tanggal_peminjaman,
            ]);

            // Reduce the barang quantity
            $barang->reduceQuantity($request->total_barang);

            return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil.');
        } catch (\Exception $e) {
            return redirect()->route('peminjaman')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
