<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriAlatController extends Controller
{
    public function index()
    {
        $kategori = KategoriAlat::all();
        return view('layout.dashboard_pengguna', compact('kategori'));
    }
}
