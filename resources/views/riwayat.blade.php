@extends('layout.riwayat')

@section('title', 'Riwayat')

@section('content')
<div class="bg-gray-100 font-poppins leading-normal tracking-normal">
    <!-- Konten -->
    <div class="w-full p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">RIWAYAT</h1>

        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-sm mb-8">
            <table class="table-auto w-full border-collapse">
                <thead>
                <tr class="bg-blue-300 text-black">
                    <th class="py-3 px-4 font-bold text-center rounded-tl-lg">No</th>
                    <th class="py-3 px-4 font-bold text-left">Nama Mahasiswa</th>
                    <th class="py-3 px-4 font-bold text-center">NIM</th>
                    <th class="py-3 px-4 font-bold text-center">Nama Barang</th>
                    <th class="py-3 px-4 font-bold text-center">Jumlah</th>
                    <th class="py-3 px-4 font-bold text-center">Jumlah Tersisa</th>
                    <th class="py-3 px-4 font-bold text-center">Jumlah Dipinjam</th>
                    <th class="py-3 px-4 font-bold text-center">Status Barang</th>
                    <th class="py-3 px-4 font-bold text-center">Tanggal Pinjam</th>
                    <th class="py-3 px-4 font-bold text-center">Tanggal Kembali</th>
                    <th class="py-3 px-4 font-bold text-center rounded-tr-lg">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayat as $index => $data)
                <tr class="bg-white border-b hover:bg-gray-100">
                    <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                    <td class="py-3 px-4">{{ $data->nama_mahasiswa }}</td>
                    <td class="py-3 px-4 text-center">{{ $data->nim }}</td>
                    <td class="py-3 px-4 text-center">{{ $data->barang->nama_barang ?? '-' }}</td>
                    <td class="py-3 px-4 text-center">{{ $data->total_barang }}</td>
                    <td class="py-3 px-4 text-center">{{ $data->barang->jumlah ?? 0 }}</td>
                    <td class="py-3 px-4 text-center">{{ $data->barang->peminjaman_count ?? 0 }}</td>
                    <td class="py-3 px-4 text-center">
                        @if (($data->barang->peminjaman_count ?? 0) > 0)
                            <span class="bg-red-200 text-red-800 px-2 py-1 rounded-full text-sm">Sedang Dipinjam</span>
                        @else
                            <span class="bg-green-200 text-green-800 px-2 py-1 rounded-full text-sm">Tersedia</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-center">{{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->format('d-m-Y') }}</td>
                    <td class="py-3 px-4 text-center">
                        @if ($data->pengembalian && $data->pengembalian->tanggal_pengembalian)
                            {{ \Carbon\Carbon::parse($data->pengembalian->tanggal_pengembalian)->format('d-m-Y') }}
                        @else
                            Belum Dikembalikan
                        @endif
                    </td>
                    <td class="py-3 px-4 text-center">
                        @if ($data->pengembalian)
                            <span class="bg-green-200 text-green-800 px-2 py-1 rounded-full text-sm">Selesai</span>
                        @else
                            <span class="bg-red-200 text-red-800 px-2 py-1 rounded-full text-sm">Belum</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="text-center py-4">Belum ada data riwayat.</td>
                </tr>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
