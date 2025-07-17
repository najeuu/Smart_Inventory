<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('jenis_barang');
        });
    }

    public function down()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Add it back in case of rollback
            $table->string('jenis_barang')->nullable(); // Or whatever its original definition was
        });
    }
};
