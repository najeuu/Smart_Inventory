@extends('layout.pengembalian')

@section('title', 'Pengembalian')

@section('content')
<div class="flex flex-col">
    <!-- Cari Data Mahasiswa -->
    <div class="mb-8 bg-orange-100 p-6 rounded-lg">
        <div class="max-w-xl">
            <label class="text-lg font-medium">Cari Data Mahasiswa</label>
            <div class="mt-2 relative">
                <input type="text" placeholder="NIM" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-200">
                <button class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Peminjam -->
    <div class="mb-8 bg-orange-100 p-6 rounded-lg">
        <h2 class="text-lg font-medium mb-4">PEMINJAM</h2>
        <div class="flex flex-wrap gap-2">
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow hover:bg-orange-50">
                3312311133
            </button>
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg shadow hover:bg-orange-50">
                3312311133
            </button>
        </div>
    </div>


    <div class="grid grid-cols-2 gap-4">
        <!-- Tabel Barang Yang Di Pinjam -->
        <div class="bg-orange-100 rounded-lg shadow-md p-4">
            <h2 class="font-medium mb-4">Barang Yang Di Pinjam</h2>
            <p>Nama: </p>
            <p class=" mb-4">NIM: </p>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow-md">
                    <thead class="bg-orange-200">
                        <tr>
                            <th class="py-2 px-4 text-left ">No</th>
                            <th class="py-2 px-4 text-left ">Nama Barang</th>
                            <th class="py-2 px-4 text-left ">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t border-grey">
                            <td class="py-2 px-4 ">1</td>
                            <td class="py-2 px-4 ">Contoh Barang</td>
                            <td class="py-2 px-4 ">10</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Hasil Scanner -->
        <div class="bg-orange-100 rounded-lg shadow-md p-4">
            <h2 class="font-medium mb-6">Hasil Scanner</h2>
            <div class="text-left">
                <button type="submit" class="px-4 mb-6 py-1 bg-green-500 text-white rounded-lg cursor-pointer">Proses</button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow-md">
                    <thead class="bg-orange-200">
                        <tr>
                            <th class="py-2 px-4 text-left ">No</th>
                            <th class="py-2 px-4 text-left ">Nama Barang</th>
                            <th class="py-2 px-4 text-left ">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t border-grey">
                            <td class="py-2 px-4 ">1</td>
                            <td class="py-2 px-4 ">Contoh Barang</td>
                            <td class="py-2 px-4 ">5</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
