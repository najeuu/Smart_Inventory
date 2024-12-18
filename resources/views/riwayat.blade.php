@extends('layout.riwayat') 

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="bg-gray-100 font-poppins leading-normal tracking-normal">
    <!-- Konten -->
    <div class="w-full p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-widest">HALO LABORAN</h1>
        <p class="text-gray-600 mb-8 tracking-wide">Selamat Datang di Halaman Riwayat Peminjaman</p>

        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-sm mb-8">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-orange-300 text-black">
                        <th class="py-3 px-4 font-bold text-center rounded-tl-lg">No</th>
                        <th class="py-3 px-4 font-bold text-left">Nama Mahasiswa</th>
                        <th class="py-3 px-4 font-bold text-center">NIM</th>
                        <th class="py-3 px-4 font-bold text-center">Tanggal Peminjaman</th>
                        <th class="py-3 px-4 font-bold text-center">Tanggal Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayat as $index => $data)
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 text-left">{{ $data->nama_mahasiswa }}</td>
                        <td class="py-3 px-4 text-center">{{ $data->nim }}</td>
                        <td class="py-3 px-4 text-center">{{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->format('d-m-Y') }}</td>
                        <td class="py-3 px-4 text-center">
                            @if ($data->pengembalian && $data->pengembalian->tanggal_pengembalian)
                                {{ \Carbon\Carbon::parse($data->pengembalian->tanggal_pengembalian)->format('d-m-Y') }}
                            @else
                                Belum Dikembalikan
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
