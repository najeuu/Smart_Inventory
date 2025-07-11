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
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->dropForeign(['peminjaman_id']);
            $table->foreign('peminjaman_id')
                ->references('id')
                ->on('peminjaman')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            $table->dropForeign(['peminjaman_id']);
            $table->foreign('peminjaman_id')
                ->references('id')
                ->on('peminjaman');
        });
    }
};
