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
            // Cek apakah kolom 'nama_mahasiswa' dan 'nim' masih ada sebelum drop
            if (Schema::hasColumn('peminjaman', 'nama_mahasiswa')) {
                $table->dropColumn('nama_mahasiswa');
            }

            if (Schema::hasColumn('peminjaman', 'nim')) {
                $table->dropColumn('nim');
            }

            // Jangan tambahkan 'user_id' lagi jika sudah ada
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
            // Tambahkan kembali jika rollback
            $table->string('nama_mahasiswa');
            $table->string('nim');

            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
