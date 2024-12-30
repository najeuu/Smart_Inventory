<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;

class BarangExport implements FromCollection
{
    public function collection()
    {
        // Mengambil data barang dari database
        return Barang::all(); // Mengambil semua data barang
    }
}
