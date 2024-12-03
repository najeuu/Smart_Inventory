<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class DataBarangController extends Controller
{
    public function show()
    {
        $data = Barang::get();
        foreach ($data as $barang){
            $nama_barang[] = $barang->nama_barang;
            $jumlah[] = $barang->jumlah;
            $lokasi[] = $barang->lokasi;
            $kode_rfid[] = $barang->kode_rfid;
        }
        return view('data_barang', compact('nama_barang', 'jumlah', 'lokasi', 'kode_rfid'));
    }
}
