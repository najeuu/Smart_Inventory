@extends('layout.laporan')

@section('title.laporan')

@section('content')
    <div class="w-screen flex flex-col mx-10 bg-gray-100 font-poppins pb-[30px]">
        <div class="pb-[30px] pt-[30px]">
            <p class="font-bold text-[25pt] tracking-widest">HALO LABORAN</p>
            <p class="mt-[-5px] tracking-wide">Selamat Datang di MANAJEMEN BARANG LABORAN</p>
        </div>
        <div class="bg-gray-200 bg-opacity-90 p-3 rounded-lg shadow-lg">
            <!-- Tombol -->
            <a href="#" class="bg-green-500 hover:bg-green-600 text-white flex items-center justify-center h-[30px] w-[120px] font-bold rounded-full mb-4 shadow-md transition duration-300">
                <span class="material-symbols-outlined text-[20px] mr-1">download</span>
                <p class="text-[12px]">Export PDF</p>
            </a>

            <!-- Tabel -->
            <div class="overflow-hidden rounded-lg">
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr class="bg-orange-400 text-white">
                            <th class="py-3 font-bold text-center rounded-tl-lg">No</th>
                            <th class="px-2 py-3 font-bold text-left">Nama Barang</th>
                            <th class="py-3 font-bold text-center">Jumlah</th>
                            <th class="px-2 py-3 font-bold text-center rounded-tr-lg">Lokasi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-orange-50">
                        <tr class="hover:bg-orange-100 transition duration-200">
                            <td class="py-3 border-t border-gray-300 text-center">1</td>
                            <td class="px-2 py-3 border-t text-left border-gray-300">Barang A</td>
                            <td class="py-3 border-t border-gray-300 text-center">10</td>
                            <td class="px-2 py-3 border-t border-gray-300 text-center">Gudang 1</td>
                        </tr>
                        <tr class="hover:bg-orange-100 transition duration-200">
                            <td class="py-3 border-t border-gray-300 text-center">1</td>
                            <td class="px-2 py-3 border-t text-left border-gray-300">Barang A</td>
                            <td class="py-3 border-t border-gray-300 text-center">10</td>
                            <td class="px-2 py-3 border-t border-gray-300 text-center">Gudang 1</td>
                        </tr>
                        <tr class="hover:bg-orange-100 transition duration-200">
                            <td class="py-3 border-t border-gray-300 text-center">1</td>
                            <td class="px-2 py-3 border-t text-left border-gray-300">Barang A</td>
                            <td class="py-3 border-t border-gray-300 text-center">10</td>
                            <td class="px-2 py-3 border-t border-gray-300 text-center">Gudang 1</td>
                        </tr>
                        <tr class="hover:bg-orange-100 transition duration-200">
                            <td class="py-3 border-t border-gray-300 text-center">1</td>
                            <td class="px-2 py-3 border-t text-left border-gray-300">Barang A</td>
                            <td class="py-3 border-t border-gray-300 text-center">10</td>
                            <td class="px-2 py-3 border-t border-gray-300 text-center">Gudang 1</td>
                        </tr>
                        <tr class="hover:bg-orange-100 transition duration-200">
                            <td class="py-3 border-t border-gray-300 text-center">1</td>
                            <td class="px-2 py-3 border-t text-left border-gray-300">Barang A</td>
                            <td class="py-3 border-t border-gray-300 text-center">10</td>
                            <td class="px-2 py-3 border-t border-gray-300 text-center">Gudang 1</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
