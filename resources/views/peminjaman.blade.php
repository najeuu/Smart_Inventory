@extends('layout.peminjaman')

@section('title', 'Peminjaman')

@section('content')

<div class="flex flex-col ml-8">

    <form action="/peminjaman" method="POST">
        <div class="mb-8 bg-orange-300 p-6 rounded-lg">
            <!-- Nama Mahasiswa -->
            <div class="mb-4">
                <label for="nama_mahasiswa" class="block font-poppins text-lg font-bold mb-2">Nama Mahasiswa</label>
                <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <!-- NIM -->
            <div class="mb-4">
                <label for="nim" class="block font-bold mb-2 font-poppins text-lg">NIM</label>
                <input type="text" id="nim" name="nim" class="w-full px-4 py-2 border rounded-lg" required>
            </div>
        </div>

        <!-- Pilih Barang -->
        <div class="mb-8 bg-orange-300 p-6 rounded-lg mb-4">
            <h2 class="font-bold mb-2 font-poppins text-lg">Pilih Barang</h2>

            <!-- Tabel -->
            <div class="overflow-hidden rounded-lg mb-4">
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr class="bg-white text-black">
                            <th class="py-3 font-bold text-center rounded-tl-lg font-poppins">No</th>
                            <th class="px-2 py-3 font-bold text-center font-poppins">Nama Barang</th>
                            <th class="py-3 font-bold text-center font-poppins">Stok Tersedia</th>
                            <th class="py-3 font-bold text-center font-poppins">Pinjam</th>
                            <th class="px-2 py-3 font-bold text-center rounded-tr-lg font-poppins">Jumlah</th>
                        </tr>
                    </thead>

                    <!-- Data Barang-->
                    <tbody class="bg-orange-50">
                        <tr class="hover:bg-orange-100 transition duration-200 font-poppins">
                            <td class="py-3 border-t border-gray-300 text-center font-poppins">1</td>
                            <td class="px-2 py-3 border-t text-center border-gray-300 font-poppins">Laptop</td>
                            <td class="py-3 border-t border-gray-300 text-center font-poppins">10</td>
                            <td class="py-2 px-4 border-t text-center border-gray-300 font-poppins">
                                <input type="checkbox" name="barang[]" value="1" class="form-checkbox">
                            </td>
                            <td class="py-2 px-4 border-t border-gray-300 font-poppins">
                                <input type="number" name="jumlah[1]" value="1" min="1" max="10" class="w-full text-center px-2 py-1 border rounded-lg">
                            </td>
                        </tr>

                        <tr class="hover:bg-orange-100 transition duration-200">
                            <td class="py-3 border-t border-gray-300 text-center font-poppins">2</td>
                            <td class="px-2 py-3 border-t text-center border-gray-300 font-poppins">Arduino</td>
                            <td class="py-3 border-t border-gray-300 text-center font-poppins">10</td>
                            <td class="py-2 px-4 border-t text-center border-gray-300 font-poppins">
                                <input type="checkbox" name="barang[]" value="1" class="form-checkbox">
                            </td>
                            <td class="py-2 px-4 border-t border-gray-300 font-poppins">
                                <input type="number" name="jumlah[1]" value="1" min="1" max="10" class="w-full px-2 py-1 border rounded-lg">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tombol Proses -->
            <div class="text-left">
                <button type="submit" class="px-6 py-2 bg-green-500 font-poppins text-white rounded-lg font-bold hover:bg-green-700 cursor-pointer">
                    Proses
                </button>
            </div>

    </form>
</div>
@endsection