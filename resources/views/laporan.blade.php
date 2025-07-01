@extends('layout.laporan')

@section('title.laporan')
    Laporan Barang
@endsection

@section('content')

<div class="bg-gray-100 font-poppins leading-normal tracking-normal">
  <div class="w-full p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-widest">HALO LABORAN</h1>
    <p class="text-gray-600 mb-8 tracking-wide">Selamat Datang di Halaman Laporan Barang</p>

    <form action="{{ route('laporan.download') }}" method="GET" class="flex flex-col mb-4">
      @csrf
      <div class="flex items-center mb-2">
        <label for="tanggal_awal" class="mr-2 text-gray-700">Tanggal Awal:</label>
        <input type="date" name="tanggal_awal" id="tanggal_awal" required class="border border-gray-300 rounded-md px-2 py-1">
      </div>
      <div class="flex items-center mb-2">
        <label for="tanggal_akhir" class="mr-2 text-gray-700">Tanggal Akhir:</label>
        <input type="date" name="tanggal_akhir" id="tanggal_akhir" required class="border border-gray-300 rounded-md px-2 py-1">
      </div>
      <div class="flex items-center">
       <label for="format" class="mr-2 text-gray-700">Unduh Laporan:</label>
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded-md flex items-center gap-1">
        <span class="material-symbols-outlined">download</span>
        <span>Export</span>
        </button>
      </div>
    </form>

    <div class="overflow-hidden rounded-lg">
      <table class="table-auto w-full border-collapse">
        <thead>
          <tr class="bg-blue-300 text-black">
            <th class="py-3 font-bold text-center rounded-tl-lg">No</th>
            <th class="px-2 py-3 font-bold text-left">Nama Barang</th>
            <th class="py-3 font-bold text-center">Jumlah</th>
            <th class="px-2 py-3 font-bold text-center">Lokasi</th>
            <th class="px-2 py-3 font-bold text-center rounded-tr-lg">Kode RFID</th> </tr>
        </thead>
        <tbody class="bg-blue-50">
          @foreach ($data as $index => $barang)
          <tr class="hover:bg-blue-100 transition duration-200">
            <td class="py-3 border-t border-gray-300 text-center">{{ $index + 1 }}</td>
            <td class="px-2 py-3 border-t text-left border-gray-300">{{ $barang->nama_barang }}</td>
            <td class="py-3 border-t border-gray-300 text-center">{{ $barang->jumlah }}</td>
            <td class="px-2 py-3 border-t border-gray-300 text-center">{{ $barang->lokasi->lokasi }}</td>
            <td class="px-2 py-3 border-t border-gray-300 text-center">{{ $barang->kode_rfid }}</td> </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
