<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('kategori_alat');
        Schema::dropIfExists('riwayat');
    }

    public function down(): void
    {
        Schema::create('kategori_alat', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });

        Schema::create('riwayat', function (Blueprint $table) {
            $table->id();
            $table->string('aktivitas');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
        });
    }
};
