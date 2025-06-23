<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriAlat;

class KategoriAlatSeeder extends Seeder
{
    public function run()
    {
        KategoriAlat::create([
            'nama_kategori' => 'Arduino Uno',
            'gambar' => 'arduino_uno.png',
        ]);

        KategoriAlat::create([
            'nama_kategori' => 'BreadBoard',
            'gambar' => 'breadboard.jpeg',
        ]);
    }
}
