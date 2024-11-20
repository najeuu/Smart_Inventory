<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\RiwayatPeminjamanController;


// login
Route::get('/', function () {
    return view('login');
});


//regis
Route::get('/register', [RegisterController::class, 'show'])->name('register');


//dasboard
Route::get('/dasboard',function(){
    return view(view: 'dasboard');
});


// data barang
Route::get('/data_barang',function(){
    return view(view: 'data_barang');
});


// Peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');


// Pengembalian
Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');


//riwayat
Route::get('/riwayat', [RiwayatPeminjamanController::class, 'index']);
Route::get('/riwayat/{id}', [RiwayatPeminjamanController::class, 'show']);


//laporan
Route::get('/laporan',function(){
    return view('laporan');
});


//setting
Route::get('/setting',function(){
    return view('setting');
});

