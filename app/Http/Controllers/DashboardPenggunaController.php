<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\KategoriBarang;
use Illuminate\Support\Facades\Auth;


class DashboardPenggunaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $kategoris = KategoriBarang::all();

        // Ambil parameter filter
        $search = $request->input('search');
        $kategoriId = $request->input('kategori');

        // Query barang
        $barangs = Barang::with('kategori')
            ->when($search, fn($q) => $q->where('nama_barang', 'like', "%$search%"))
            ->when($kategoriId, fn($q) => $q->where('kategori_id', $kategoriId))
            ->get();

        return view('dashboard_pengguna', compact('user', 'kategoris', 'barangs', 'search', 'kategoriId'));
    }
}
