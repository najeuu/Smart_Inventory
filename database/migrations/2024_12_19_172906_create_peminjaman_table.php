<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanTable extends Migration
{
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mahasiswa');
            $table->string('nim');
            $table->string('jenis_barang');
            $table->foreignId('barang_id')->nullable()->constrained('barangs')->onDelete('cascade');
            $table->integer('total_barang');
            $table->date('tanggal_peminjaman');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman');
    }
}