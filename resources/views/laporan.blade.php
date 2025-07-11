@extends('layout.laporan')

@section('title.laporan')
    Laporan Barang
@endsection

@section('content')
<div class="bg-gray-100 font-poppins leading-normal tracking-normal">
    <div class="w-full p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 tracking-wider">LAPORAN DATA BARANG</h1>

        {{-- Tombol Unduh PDF --}}
        <a href="{{ route('laporan.download') }}"
        class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-md shadow-md transition duration-200 mb-4">
                <span class="material-symbols-outlined">download</span>
                <span>Unduh PDF</span>
                </a>
            </button>
        </form>

        {{-- Tabel Laporan --}}
        <div class="overflow-hidden rounded-lg shadow-md">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300 text-black">
                        <th class="py-3 font-bold text-center rounded-tl-lg">No</th>
                        <th class="px-4 py-3 font-bold text-left">Nama Barang</th>
                        <th class="py-3 font-bold text-center">Jumlah</th>
                        <th class="px-4 py-3 font-bold text-center">Lokasi</th>
                        <th class="px-4 py-3 font-bold text-center rounded-tr-lg">Kode RFID</th>
                    </tr>
                </thead>
                <tbody class="bg-blue-50">
                    @forelse ($data as $index => $barang)
                    <tr class="hover:bg-blue-100 transition duration-200">
                        <td class="py-3 border-t border-gray-300 text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 border-t border-gray-300">{{ $barang->nama_barang }}</td>
                        <td class="py-3 border-t border-gray-300 text-center">{{ $barang->jumlah }}</td>
                        <td class="px-4 py-3 border-t border-gray-300 text-center">{{ $barang->lokasi->lokasi }}</td>
                        <td class="px-4 py-3 border-t border-gray-300 text-center">{{ $barang->kode_rfid }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">Tidak ada data barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
