@extends('layout.riwayat-pengguna')

@section('title', 'Riwayat')

@section('content')
    <div class="bg-gray-100 font-poppins leading-normal tracking-normal">
        <div class="w-full p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-4 uppercase text-center">
        RIWAYAT PEMINJAMAN {{ auth()->user()->nama_mahasiswa ?? 'Laboran' }}
    </h1>

        <div class="overflow-y-auto rounded-lg border border-gray-300 shadow-sm mb-8">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-blue-300 text-black leading-normal">
                        <th class="py-3 px-6 text-center">No</th>
                        <th class="py-3 px-6 text-left">Nama Barang</th>
                        <th class="py-3 px-6 text-center">Jumlah Dipinjam</th>
                        <th class="py-3 px-6 text-center">Jumlah Dikembalikan</th>
                        <th class="py-3 px-6 text-center">Tanggal Peminjaman</th>
                        <th class="py-3 px-6 text-center">Tanggal Pengembalian</th>
                        <th class="py-3 px-6 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="text-black-600">
                    @forelse($riwayat as $index => $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-center">{{ $index + 1 }}</td>
                            <td class="py-3 px-6 text-left">{{ $item->barang->nama_barang }}</td>
                            <td class="py-3 px-6 text-center">{{ $item->total_barang }}</td> {{-- Fix --}}
                            <td class="py-3 px-6 text-center">{{ $item->jumlah_dikembalikan }}</td>
                            <td class="py-3 px-6 text-center">
                                {{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d-m-Y') }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                {{ $item->tanggal_pengembalian_terakhir ? \Carbon\Carbon::parse($item->tanggal_pengembalian_terakhir)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                @if ($item->jumlah_dikembalikan == 0)
                                    <span class="text-red-500 font-semibold">Belum dikembalikan</span>
                                @elseif ($item->jumlah_dikembalikan < $item->total_barang)
                                    <span class="text-yellow-500 font-semibold">Sebagian dikembalikan</span>
                                @else
                                    <span class="text-green-500 font-semibold">Sudah dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-4">Tidak ada riwayat peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex justify-center">
        {{ $riwayat->links() }}
        </div>
    </div>
</div>
@endsection
