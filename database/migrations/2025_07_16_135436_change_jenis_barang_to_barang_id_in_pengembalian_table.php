<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            // Hapus kolom 'jenis_barang' yang sudah ada
            $table->dropColumn('jenis_barang');

            // Tambahkan kolom 'barang_id'
            // Tipe data harus sesuai dengan 'id' di tabel 'barangs', umumnya bigint unsigned
            $table->bigInteger('barang_id')->unsigned()->nullable()->after('peminjaman_id');

            // Tambahkan foreign key constraint
            // Ini akan memastikan integritas referensial ke tabel 'barangs'
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengembalian', function (Blueprint $table) {
            // Drop foreign key constraint terlebih dahulu
            $table->dropForeign(['barang_id']);

            // Hapus kolom 'barang_id'
            $table->dropColumn('barang_id');

            // Tambahkan kembali kolom 'jenis_barang' jika migrasi di-rollback
            $table->string('jenis_barang', 255)->nullable()->after('peminjaman_id');
        });
    }
};
