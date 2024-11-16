@extends('layout.peminjaman')

@section('title', 'Peminjaman')

@section('content')
<div class="flex flex-col">

        <form action="/peminjaman" method="POST">
        <div class="mb-8 bg-orange-100 p-6 rounded-lg">
            <!-- Nama Mahasiswa -->
            <div class="mb-4">
                <label for="nama_mahasiswa" class="block text-gray-700 font-bold mb-2">Nama Mahasiswa</label>
                <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <!-- NIM -->
            <div class="mb-4">
                <label for="nim" class="block text-gray-700 font-bold mb-2">NIM</label>
                <input type="text" id="nim" name="nim" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
        </div>

            <!-- Pilih Barang -->
            <div class="mb-8 bg-orange-100 p-6 rounded-lg">
            <div class="mb-4">
                <h2 class="text-gray-700 font-bold mb-2">Pilih Barang</h2>
                <table class="min-w-full bg-white border rounded-lg">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b">No</th>
                            <th class="py-2 px-4 border-b">Nama Barang</th>
                            <th class="py-2 px-4 border-b">Stok Tersedia</th>
                            <th class="py-2 px-4 border-b">Pinjam</th>
                            <th class="py-2 px-4 border-b">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data Barang-->
                        <tr>
                            <td class="py-2 px-4 border-b">1</td>
                            <td class="py-2 px-4 border-b">Laptop</td>
                            <td class="py-2 px-4 border-b">10</td>
                            <td class="py-2 px-4 border-b text-center">
                                <input type="checkbox" name="barang[]" value="1" class="form-checkbox">
                            </td>
                            <td class="py-2 px-4 border-b">
                                <input type="number" name="jumlah[1]" value="1" min="1" max="10" class="w-full px-2 py-1 border rounded-lg">
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 px-4 border-b">2</td>
                            <td class="py-2 px-4 border-b">Proyektor</td>
                            <td class="py-2 px-4 border-b">5</td>
                            <td class="py-2 px-4 border-b text-center">
                                <input type="checkbox" name="barang[]" value="2" class="form-checkbox">
                            </td>
                            <td class="py-2 px-4 border-b">
                                <input type="number" name="jumlah[2]" value="1" min="1" max="5" class="w-full px-2 py-1 border rounded-lg">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tombol Proses -->
            <div class="text-left">
                <button type="submit" class="px-6 py-2" style="background-color: #48bb78; color: white; border-radius: 8px; cursor: pointer;">Proses</button>
            </div>
        </form>
    </div>
@endsection
