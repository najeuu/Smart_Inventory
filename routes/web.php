<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\RiwayatPeminjamanController;

Route::get('/riwayat-peminjaman', [RiwayatPeminjamanController::class, 'index']);
Route::get('/riwayat-peminjaman/{id}', [RiwayatPeminjamanController::class, 'show']);
