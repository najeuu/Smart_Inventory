<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Return view peminjaman
        return view('peminjaman');
    }
}
