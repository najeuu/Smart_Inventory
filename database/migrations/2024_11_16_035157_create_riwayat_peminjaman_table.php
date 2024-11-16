<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiwayatPeminjamanTable extends Migration
{
    public function up()
    {
        Schema::create('riwayat_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mahasiswa');
            $table->string('nim');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian')->nullable();
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('riwayat_peminjaman');
    }
};
