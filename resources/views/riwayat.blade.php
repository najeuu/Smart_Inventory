@extends('layout.riwayat')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="bg-gray-100 font-poppins leading-normal tracking-normal">
    <!-- Konten -->
    <div class="w-full p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-widest">HALO LABORAN</h1>
        <p class="text-gray-600 mb-8 tracking-wide">Selamat Datang di Halaman Riwayat Peminjaman</p>

        <table class="w-full bg-orange-300 border border-gray-200 rounded-md overflow-hidden shadow">
            <thead class="text-black">
                <tr>
                    <th class="py-3 px-4 text-left border-b">No</th>
                    <th class="py-3 px-4 text-left border-b">Nama Mahasiswa</th>
                    <th class="py-3 px-4 text-left border-b">NIM</th>
                    <th class="py-3 px-4 text-left border-b">Tanggal Peminjaman</th>
                    <th class="py-3 px-4 text-left border-b">Tanggal Pengembalian</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @foreach($riwayat as $index => $data)
                <tr class="border-b">
                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                    <td class="py-3 px-4">{{ $data->nama_mahasiswa }}</td>
                    <td class="py-3 px-4">{{ $data->nim }}</td>
                    <td class="py-3 px-4">{{ $data->tanggal_peminjaman }}</td>
                    <td class="py-3 px-4">{{ $data->tanggal_pengembalian }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </body>
    @endsection