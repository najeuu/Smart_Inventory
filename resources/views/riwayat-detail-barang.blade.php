@extends('layout.riwayat')

@section('title', 'Detail Riwayat Barang')

@section('content')
<div class="bg-gray-100 p-8 font-poppins">
    <h1 class="text-3xl font-bold mb-6">Detail Riwayat Barang</h1>

    <!-- Informasi Barang -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">{{ $barang->nama_barang }}</h2>

        @php
            $totalDikembalikan = $barang->peminjaman->flatMap->pengembalians->sum('jumlah');
            $totalDipinjam = $barang->peminjaman->sum('total_barang') - $totalDikembalikan;
            $totalBarang = $barang->jumlah + $totalDipinjam;
        @endphp

        <table class="w-full text-sm text-gray-700">
            <tbody>
                <tr class="border-b">
                    <td class="py-2 w-1/3 font-semibold">Kategori</td>
                    <td class="py-2 w-1/12 text-center">:</td>
                    <td class="py-2">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 font-semibold">Lokasi</td>
                    <td class="py-2 text-center">:</td>
                    <td class="py-2">{{ $barang->lokasi->lokasi ?? '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 font-semibold">Total Barang</td>
                    <td class="py-2 text-center">:</td>
                    <td class="py-2">{{ $totalBarang }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 font-semibold">Stok Barang</td>
                    <td class="py-2 text-center">:</td>
                    <td class="py-2">{{ $barang->jumlah }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 font-semibold">Total Dipinjam</td>
                    <td class="py-2 text-center">:</td>
                    <td class="py-2">{{ $totalDipinjam }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 font-semibold">Total Dikembalikan</td>
                    <td class="py-2 text-center">:</td>
                    <td class="py-2">{{ $totalDikembalikan }}</td>
                </tr>
                <tr>
                    <td class="py-2 font-semibold">Jumlah Transaksi Peminjaman</td>
                    <td class="py-2 text-center">:</td>
                    <td class="py-2">{{ $barang->peminjaman->count() }}</td>
                </tr>
            </tbody>
        </table>
    </div>


        <!-- Form Pencarian & Export -->
        <form method="GET" class="flex flex-wrap items-center gap-3 mb-4">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama mahasiswa..."
                class="border border-gray-300 px-4 py-2 rounded shadow-sm focus:outline-none focus:ring focus:border-blue-300"
            >
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Cari</button>

            <button type="submit" name="download" value="1"
                class="ml-auto bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Download PDF
            </button>
        </form>

    <!-- Tabel Riwayat Peminjaman -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead class="bg-blue-200 text-gray-700">
                <tr>
                    <th class="py-2 px-4 text-left">Nama Mahasiswa</th>
                    <th class="py-2 px-4 text-center">NIM</th>
                    <th class="py-2 px-4 text-center">Tanggal Pinjam</th>
                    <th class="py-2 px-4 text-center">Tanggal Kembali Terakhir</th>
                    <th class="py-2 px-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayatPeminjaman as $riwayat)
                    <tr class="border-t">
                        <td class="py-2 px-4">{{ $riwayat['nama_mahasiswa'] }}</td>
                        <td class="py-2 px-4 text-center">{{ $riwayat['nim'] }}</td>
                        <td class="py-2 px-4 text-center">
                            {{ \Carbon\Carbon::parse($riwayat['tanggal_pinjam'])->format('d-m-Y') }}
                        </td>
                        <td class="py-2 px-4 text-center">
                            {{ $riwayat['tanggal_pengembalian_terakhir']
                                ? \Carbon\Carbon::parse($riwayat['tanggal_pengembalian_terakhir'])->format('d-m-Y')
                                : '-' }}
                        </td>
                        <td class="py-2 px-4 text-center">
                            @if($riwayat['status'] == 'Belum dikembalikan')
                                <span class="text-red-600">{{ $riwayat['status'] }}</span>
                            @elseif($riwayat['status'] == 'Sebagian dikembalikan')
                                <span class="text-yellow-600">{{ $riwayat['status'] }}</span>
                            @else
                                <span class="text-green-600">{{ $riwayat['status'] }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Tidak ada riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Navigasi -->
    <div class="mt-6 flex justify-between items-center">
        <a href="{{ route('riwayat') }}" class="text-gray-600 hover:underline">← Kembali ke Riwayat Barang</a>
    </div>
</div>
@endsection
