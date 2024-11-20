@extends('layout.pengembalian')

@section('title', 'Pengembalian')

@section('content')
<div class="flex flex-col ml-">
    <!-- Cari Data Mahasiswa -->
    <div class="mb-8 bg-orange-300 p-6 rounded-lg">
        <div class="max-w-xl">
            <label class="text-lg font-bold font-poppins">Cari Data Mahasiswa</label>
            <div class="mt-2 relative">
                <input type="text" placeholder="NIM" class="w-full px-4 font-poppins py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-300">
                <button class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Peminjam -->
    <div class="mb-8 bg-orange-300 p-6 rounded-lg">
        <h2 class="text-lg font-bold mb-4 font-poppins">PEMINJAM</h2>
        <div class="flex flex-wrap gap-2">
            <button class="px-4 py-2 bg-white font-poppins border border-gray-300 rounded-lg shadow hover:bg-orange-50">
                3312311133
            </button>
            <button class="px-4 py-2 bg-white border font-poppins border-gray-300 rounded-lg shadow hover:bg-orange-50">
                3312311133
            </button>
        </div>
    </div>


    <div class="grid grid-cols-2 gap-4">
        <!-- Tabel Barang Yang Di Pinjam -->
        <div class="bg-orange-300 rounded-lg shadow-md p-4">
            <h2 class="font-bold font-poppins mb-4 text-lg">Barang Yang Di Pinjam</h2>
            <p class="font-poppins">Nama: </p>
            <p class=" mb-4 font-poppins">NIM: </p>

            <div class="overflow-x-auto rounded-lg mb-4">
                <table class="table-auto w-full border-collapse ">
                    <thead>
                        <tr class="bg-white text-black">
                            <th class="py-3 font-bold text-center border-t border-gray-300 rounded-tl-lg font-poppins">No</th>
                            <th class="px-2 py-3 font-bold text-center border-t border-gray-300 font-poppins">Nama Barang</th>
                            <th class="py-3 font-bold text-center border-t border-gray-300 font-poppins">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-orange-50">
                    <tr class="hover:bg-orange-100 transition duration-200 font-poppins">
                        <tr class="border-t border-grey-300">
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">1</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">Arduino</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">10</td>
                        </tr>
                        <tr class="border-t border-grey-300">
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">1</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">Arduino</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">10</td>
                        </tr>
                        <tr class="border-t border-grey-300">
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">1</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">Arduino</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">10</td>
                        </tr>
                        <tr class="border-t border-grey-300">
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">1</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">Arduino</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">10</td>
                        </tr>
                        <tr class="border-t border-grey-300">
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">1</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">Arduino</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">10</td>
                        </tr>
                        <tr class="border-t border-grey-300">
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">1</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">Arduino</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">10</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Hasil Scanner -->
        <div class="bg-orange-300 rounded-lg shadow-md p-4">
            <h2 class="font-bold mb-6 font-poppins text-lg">Hasil Scanner</h2>
            <div class="text-left">
                <button type="submit" class="px-4 mb-6 py-1 bg-green-500 font-poppins font-bold text-white rounded-lg cursor-pointer">Proses</button>
            </div>

            <div class="overflow-x-auto rounded-lg mb-4">
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr class="bg-white text-black">
                            <th class="py-3 font-bold text-center border-t border-gray-300 rounded-tl-lg font-poppins">No</th>
                            <th class="px-2 py-3 font-bold text-center border-t border-gray-300 font-poppins">Nama Barang</th>
                            <th class="py-3 font-bold text-center border-t border-gray-300 font-poppins">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-orange-50">
                    <tr class="hover:bg-orange-100  transition duration-200 font-poppins">
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">1</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">Arduino</td>
                            <td class="py-2 px-4 font-poppins border-t border-gray-300 text-center">10</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
