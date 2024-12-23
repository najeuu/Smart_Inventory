@extends('layout.laporan')

@section('title.laporan')
    Laporan Barang
@endsection

@section('content')

<div class="bg-gray-100 font-poppins leading-normal tracking-normal">
    <!-- Konten -->
    <div class="w-full p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-widest">HALO LABORAN</h1>
        <p class="text-gray-600 mb-8 tracking-wide">Selamat Datang di Halaman Laporan Barang</p>

        <!-- Tombol Export PDF -->
        <a href="{{ route('laporan.download') }}" class="bg-green-500 hover:bg-green-600 text-white flex items-center justify-center h-[30px] w-[120px] font-bold rounded-lg mb-4 shadow-md transition duration-300">
            <span class="material-symbols-outlined text-[20px] mr-1">download</span>
            <p class="text-[12px]">Export PDF</p>
        </a>

        <!-- Tabel -->
        <div class="overflow-hidden rounded-lg">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-orange-300 text-black">
                        <th class="py-3 font-bold text-center rounded-tl-lg">No</th>
                        <th class="px-2 py-3 font-bold text-left">Nama Barang</th>
                        <th class="py-3 font-bold text-center">Jumlah</th>
                        <th class="px-2 py-3 font-bold text-center">Lokasi</th>
                        <th class="px-2 py-3 font-bold text-center rounded-tr-lg">Kode RFID</th> <!-- Kolom Kode RFID -->
                    </tr>
                </thead>
                <tbody class="bg-orange-50">
                    @foreach ($data as $index => $barang)
                    <tr class="hover:bg-orange-100 transition duration-200">
                        <td class="py-3 border-t border-gray-300 text-center">{{ $index + 1 }}</td>
                        <td class="px-2 py-3 border-t text-left border-gray-300">{{ $barang->nama_barang }}</td>
                        <td class="py-3 border-t border-gray-300 text-center">{{ $barang->jumlah }}</td>
                        <td class="px-2 py-3 border-t border-gray-300 text-center">{{ $barang->lokasi->lokasi }}</td>
                        <td class="px-2 py-3 border-t border-gray-300 text-center">{{ $barang->kode_rfid }}</td> <!-- Menampilkan Kode RFID -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
