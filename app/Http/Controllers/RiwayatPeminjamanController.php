<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPeminjaman;

class RiwayatPeminjamanController extends Controller
{
    public function index()
    {
        $riwayat = RiwayatPeminjaman::all();
        return view('RiwayatPeminjaman', compact('riwayat'));
    }
}
