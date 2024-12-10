<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\RiwayatPeminjamanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\DataBarangController;



// login
Route::get('/', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');


//regis
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

//logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Dasboard
Route::get('/dasboard', [DasboardController::class, 'index'])->name('dasboard')->middleware('auth');


//Data barang
Route::get('/data_barang', [DataBarangController::class, 'show'])->name('data_barang');
Route::post('/data_barang', [DataBarangController::class, 'store'])->name('barang.store');
Route::put('/data_barang/{id}', [DataBarangController::class, 'update'])->name('barang.update');
Route::delete('/data_barang/{id}', [DataBarangController::class, 'destroy'])->name('barang.destroy');


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

// logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
