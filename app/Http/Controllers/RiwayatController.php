<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Riwayat;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = Peminjaman::with('pengembalian')->get();

        return view('riwayat', compact('riwayat'));
    }
}
