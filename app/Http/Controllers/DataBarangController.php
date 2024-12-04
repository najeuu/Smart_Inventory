<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class DataBarangController extends Controller
{
    public function show()
    {
        $data = Barang::get();
        $nama_barang = [];
        $jumlah = [];
        $lokasi = [];
        $kode_rfid = [];
        foreach ($data as $barang) {
            $nama_barang[] = $barang->nama_barang;
            $jumlah[] = $barang->jumlah;
            $lokasi[] = $barang->lokasi;
            $kode_rfid[] = $barang->kode_rfid;
        }
        return view('data_barang', compact('nama_barang', 'jumlah', 'lokasi', 'kode_rfid', 'data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'lokasi' => 'required|string|max:255',
            'kode_rfid' => 'required|string|max:255',
        ]);

        Barang::create($request->all());

        return redirect()->route('data_barang')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer',
            'lokasi' => 'required|string|max:255',
            'kode_rfid' => 'required|string|max:255',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return redirect()->route('data_barang')->with('success', 'Barang berhasil diupdate.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('data_barang')->with('success', 'Barang berhasil dihapus.');
    }
}