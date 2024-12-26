<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\SettingController;


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
Route::get('/dashboard/almost-out-items', [DasboardController::class, 'getAlmostOutItems']);

//Data barang
Route::get('/data_barang', [DataBarangController::class, 'show'])->name('data_barang');
Route::post('/data_barang', [DataBarangController::class, 'store'])->name('barang.store');
Route::put('/data_barang/{id}', [DataBarangController::class, 'update'])->name('barang.update');
Route::delete('/data_barang/{id}', [DataBarangController::class, 'destroy'])->name('barang.destroy');

// Peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'show'])->name('peminjaman');
Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');

// Pengembalian
Route::get('/pengembalian', [PengembalianController::class, 'cari']);
Route::get('/pengembalian/cari', [PengembalianController::class, 'cari'])->name('pengembalian.cari');
Route::post('/pengembalian/store', [PengembalianController::class, 'store'])->name('pengembalian.store');

//riwayat
Route::get('/riwayat', [RiwayatController::class, 'index']);
Route::get('/riwayat/{id}', [RiwayatController::class, 'show']);

//lokasi
Route::get('/lokasi', [LokasiController::class, 'show'])->name('lokasi');
Route::post('/lokasi', [LokasiController::class, 'store'])->name('lokasi.store');
Route::put('/lokasi/{id}', [LokasiController::class, 'update'])->name('lokasi.update');
Route::delete('/lokasi/{id}', [LokasiController::class, 'destroy'])->name('lokasi.destroy');

//laporan
Route::get('/laporan', [DataBarangController::class, 'index'])->name('laporan');

// Route untuk mengunduh laporan PDF
Route::get('/laporan/download', [DataBarangController::class, 'downloadPDF'])->name('laporan.download');

//setting
Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');

// logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
