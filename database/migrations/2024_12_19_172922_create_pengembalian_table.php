<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengembalianTable extends Migration
{
    public function up()
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->string('nim'); 
            $table->string('jenis_barang');
            $table->foreignId('peminjaman_id')->constrained('peminjaman', 'id'); // menghubungkanke ke tabel peminjaman
            $table->integer('jumlah'); 
            $table->timestamp('tanggal_pengembalian')->useCurrent(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengembalian');
    }
}
