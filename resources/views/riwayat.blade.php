@extends('layout.riwayat')

@section('title', 'Riwayat Admin')

@section('content')
<div class="bg-gray-100 font-poppins leading-normal tracking-normal">
    <div class="w-full p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">RIWAYAT BARANG</h1>

        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-sm mb-8">
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-blue-300 text-black text-center">
                        <th class="py-3 px-4">No</th>
                        <th class="py-3 px-4 text-left">Nama Barang</th>
                        <th class="py-3 px-4">Total Barang</th>
                        <th class="py-3 px-4">Stok Barang</th>
                        <th class="py-3 px-4">Barang Dipinjam</th>
                        <th class="py-3 px-4">Jumlah Transaksi Peminjaman</th>
                        <th class="py-3 px-4">Jumlah Transaksi Pengembalian</th>
                        <th class="py-3 px-4">Status Barang</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @forelse ($riwayat as $index => $item)
                    <tr class="border-b hover:bg-gray-100 text-center">
                        <td class="py-2 px-4">{{ $index + 1 }}</td>
                        <td class="py-2 px-4 text-left font-medium">{{ $item['nama_barang'] }}</td>
                        <td class="py-2 px-4">{{ $item['total_barang'] }}</td>
                        <td class="py-2 px-4">{{ $item['stok_barang'] }}</td>
                        <td class="py-2 px-4">{{ $item['total_dipinjam'] }}</td>
                        <td class="py-2 px-4">{{ $item['jumlah_transaksi_peminjaman'] }}</td>
                        <td class="py-2 px-4">{{ $item['jumlah_transaksi_pengembalian'] }}</td>
                        <td class="py-2 px-4">
                            @if ($item['total_dipinjam'] > 0 && $item['total_dikembalikan'] < $item['total_dipinjam'])
                                <span class="text-yellow-600 font-semibold">Sebagian Dikembalikan</span>
                            @elseif ($item['total_dipinjam'] > 0 && $item['total_dikembalikan'] == 0)
                                <span class="text-red-600 font-semibold">Sedang Dipinjam</span>
                            @else
                                <span class="text-green-600 font-semibold">Tersedia</span>
                            @endif
                        </td>
                        <td class="py-2 px-4">
                            <a href="{{ route('riwayat.detail', $item['id']) }}" class="text-blue-600 underline">Lihat</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-gray-500">Tidak ada data riwayat barang.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
