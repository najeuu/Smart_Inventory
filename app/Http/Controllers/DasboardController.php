<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DasboardController extends Controller
{
    public function index()
    {
        // Menghitung barang yang tersedia (jumlah > 0)
        $availableItems = Barang::where('jumlah', '>', 0)->sum('jumlah');

        // Menghitung barang yang hampir habis (jumlah <= 3)
        $almostOutItems = Barang::where('jumlah', '<=', 3)->count();

        // Menghitung total barang
        $totalItems = Barang::sum('jumlah');

        // Menghitung barang yang dipinjam
        $borrowedItems = Peminjaman::whereDoesntHave('pengembalian')->sum('total_barang');

        return view('dasboard', compact('availableItems', 'almostOutItems', 'totalItems', 'borrowedItems'));
    }

    // Endpoint untuk jumlah barang hampir habis
    public function getAlmostOutItems()
    {
        // Ambil nama barang yang hampir habis (jumlah <= 3)
        $almostOutItems = Barang::where('jumlah', '<=', 3)->pluck('nama_barang');
    
        // Ambil jumlah barang yang tersedia (jumlah > 0)
        $availableItemsCount = Barang::where('jumlah', '>', 0)->sum('jumlah');
        
        return response()->json([
            'almostOutItems' => $almostOutItems, // Mengirim nama barang yang hampir habis
            'availableItemsCount' => $availableItemsCount, // Mengirim jumlah barang yang tersedia
        ]);
    }
}
