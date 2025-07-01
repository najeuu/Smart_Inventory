<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KategoriAlat;


class DashboardPenggunaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view ('layout.dashboard_pengguna', compact('user'));
    }
}
