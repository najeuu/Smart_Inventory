<?php

// database/migrations/xxxx_xx_xx_create_kategori_alat_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriAlatTable extends Migration
{
    public function up()
    {
    Schema::create('kategori_alat', function (Blueprint $table) {
    $table->id();
    $table->string('nama_kategori'); 
    $table->string('gambar');        
    $table->timestamps();
    });

    }

    public function down()
    {
        Schema::dropIfExists('kategori_alat');
    }
}
