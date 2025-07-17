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
            // Drop hanya jika kolom ada
            if (Schema::hasColumn('peminjaman', 'nama_mahasiswa')) {
                $table->dropColumn('nama_mahasiswa');
            }
            if (Schema::hasColumn('peminjaman', 'nim')) {
                $table->dropColumn('nim');
            }

            // Tambahkan user_id hanya jika belum ada
            if (!Schema::hasColumn('peminjaman', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
            }
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->string('nama_mahasiswa');
            $table->string('nim');
        });
    }
};
