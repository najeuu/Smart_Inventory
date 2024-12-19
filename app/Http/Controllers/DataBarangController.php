<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class DataBarangController extends Controller
{
    public function show()
    {
        $data = Barang::get();
        return view('data_barang', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_rfid' => 'required|unique:barangs,kode_rfid',
        'nama_barang' => 'required',
        'jumlah' => 'required|integer|min:1',
        'lokasi' => 'required',
    ], [
        'kode_rfid.required' => 'RFID Tag harus diisi.',
        'kode_rfid.unique' => 'RFID Tag sudah digunakan.',
        'nama_barang.required' => 'Nama barang harus diisi.',
        'jumlah.required' => 'Jumlah harus diisi.',
        'jumlah.integer' => 'Jumlah harus berupa angka.',
        'jumlah.min' => 'Jumlah harus lebih dari atau sama dengan 0.',
        'lokasi.required' => 'Lokasi harus diisi.',
    ]);

        Barang::create($request->all());

        return redirect()->route('data_barang')->with('success', 'Barang baru berhasil ditambahkan ke dalam sistem.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'nama_barang' => 'required|string|max:255',
        'jumlah' => 'required|integer|min:1',
        'lokasi' => 'required|string|max:255',
        'kode_rfid' => 'required|string|max:255|unique:barangs,kode_rfid,' . $id,
    ], [
        'kode_rfid.required' => 'RFID Tag harus diisi.',
        'kode_rfid.unique' => 'RFID Tag sudah digunakan.',
        'nama_barang.required' => 'Nama barang harus diisi.',
        'jumlah.required' => 'Jumlah harus diisi.',
        'jumlah.integer' => 'Jumlah harus berupa angka.',
        'jumlah.min' => 'Jumlah harus lebih dari atau sama dengan 0.',
        'lokasi.required' => 'Lokasi harus diisi.',
    ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('data_barang')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        // Cek apakah barang sedang dipinjam
    if ($barang->peminjaman()->exists()) {
        return redirect()->route('data_barang')->with('error', 'Barang sedang dipinjam, tidak dapat dihapus.');
    }
        $barang->delete();

        return redirect()->route('data_barang')->with('success', 'Data barang berhasil dihapus dari sistem.');
    }
}
