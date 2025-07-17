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
        Schema::table('peminjaman', function (Blueprint $table) {
            // Add the kode_rfid column. Make it nullable if it's optional,
            // or ensure your form always provides it if not nullable.
            $table->string('kode_rfid')->nullable()->after('total_barang'); // or 'user_id' based on your preference
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('kode_rfid');
        });
    }
};
