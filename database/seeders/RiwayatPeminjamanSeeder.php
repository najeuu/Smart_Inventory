<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RiwayatPeminjamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run()
        {
            Peminjaman::create([
                'nama_mahasiswa' => 'Ahmad Hidayat',
                'nim' => '12345678',
                'tanggal_peminjaman' => '2024-11-01',
                'tanggal_pengembalian' => '2024-11-10',
            ]);
    
            Peminjaman::create([
                'nama_mahasiswa' => 'Putri Ayu',
                'nim' => '87654321',
                'tanggal_peminjaman' => '2024-11-05',
                'tanggal_pengembalian' => null,
            ]);
        }
    }

