<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;

Route::get('/', function () {
    return view('welcome');
});

// Peminjaman Routes
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');

// Pengembalian Routes 
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');
    
use App\Http\Controllers\RiwayatPeminjamanController;

Route::get('/riwayat-peminjaman', [RiwayatPeminjamanController::class, 'index']);
Route::get('/riwayat-peminjaman/{id}', [RiwayatPeminjamanController::class, 'show']);
