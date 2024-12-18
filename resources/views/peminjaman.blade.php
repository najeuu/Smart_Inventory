@extends('layout.peminjaman')

@section('title', 'Peminjaman')

@section('content')

<div class="bg-gray-100 font-poppins leading-normal tracking-normal">
    <!-- Pop-up Success -->
    @if (session('success'))
    <div id="success-popup" class="fixed top-0 left-0 w-full h-full bg-gray-700 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="bg-orange-300 h-16 max-w-xs w-auto p-4 rounded-lg shadow-lg text-center">
            <p class="font-bold text-white mt-2">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Pop-up Error (jika stok barang tidak cukup) -->
    @if (session('error'))
    <div id="error-popup" class="fixed top-0 left-0 w-full h-full bg-red-700 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="bg-red-500 h-16 max-w-xs w-auto p-4 rounded-lg shadow-lg text-center">
            <p class="font-bold text-white mt-2">{{ session('error') }}</p>
        </div>
    </div>
    @endif

    <div class="w-full p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-widest">HALO LABORAN</h1>
        <p class="text-gray-600 mb-8 tracking-wide">Selamat Datang di Halaman Peminjaman</p>

        <!-- Button Ajukan Peminjaman -->
        <a href="javascript:void(0)" onclick="openForm()" class="bg-orange-300 hover:bg-orange-600 text-white flex items-center justify-center h-[40px] w-[200px] font-bold rounded-lg mb-4 shadow-md transition duration-300">
            <span class="material-symbols-outlined text-[20px] mr-1">add</span>
            <p class="text-[15px]">Ajukan Peminjaman</p>
        </a>

        <!-- Tabel Daftar Peminjaman -->
        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-sm mb-8">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-orange-300 text-black">
                        <th class="py-3 px-4 font-bold text-center rounded-tl-lg">No</th>
                        <th class="py-3 px-4 font-bold text-left">Nama Mahasiswa</th>
                        <th class="py-3 px-4 font-bold text-center">NIM</th>
                        <th class="py-3 px-4 font-bold text-center">Jenis Barang</th>
                        <th class="py-3 px-4 font-bold text-center">Total Barang</th>
                        <th class="py-3 px-4 font-bold text-center rounded-tr-lg">Tanggal Peminjaman</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $peminjaman)
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 text-left">{{ $peminjaman->nama_mahasiswa }}</td>
                        <td class="py-3 px-4 text-center">{{ $peminjaman->nim }}</td>
                        <td class="py-3 px-4 text-center">{{ $peminjaman->jenis_barang }}</td>
                        <td class="py-3 px-4 text-center">{{ $peminjaman->total_barang }}</td>
                        <td class="py-3 px-4 text-center">{{ $peminjaman->tanggal_peminjaman }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Form Peminjaman -->
        <div id="ajukan-peminjaman" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
            <div class="bg-white w-1/2 p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500">
                <h2 class="text-xl font-bold mb-4">Form Peminjaman</h2>
                <form action="{{ route('peminjaman.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Nama Mahasiswa</label>
                        <input type="text" name="nama_mahasiswa" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan nama mahasiswa" required />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">NIM</label>
                        <input type="text" name="nim" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan nim" required />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Jenis Barang</label>
                        <select name="jenis_barang" class="w-full px-3 py-2 border rounded-lg block text-gray-700" required>
                            <option value="" disabled selected>Pilih Jenis Barang</option>
                            @foreach ($dataBarang as $barang)
                            <option value="{{ $barang->nama_barang }}">{{ $barang->nama_barang }} (Tersedia: {{ $barang->jumlah }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-4 mb-4">
                        <div class="flex-1">
                            <label class="block text-gray-700 font-medium mb-2">Total Barang</label>
                            <input type="number" name="total_barang" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan total barang" required />
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 font-medium mb-2">Tanggal Peminjaman</label>
                            <input type="date" name="tanggal_peminjaman" class="w-full px-3 py-2 border rounded-lg block text-gray-700" placeholder="Masukkan tanggal peminjaman" required />
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2" onclick="closeForm()">Batal</button>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- JavaScript -->
        <script>
            const ajukanPeminjaman = document.getElementById('ajukan-peminjaman');
            const formContent = ajukanPeminjaman.querySelector('div');
            const successPopup = document.getElementById('success-popup');
            const errorPopup = document.getElementById('error-popup');

            if (successPopup) {
                successPopup.classList.remove('pointer-events-none', 'opacity-0');
                successPopup.classList.add('opacity-100');

                setTimeout(() => {
                    closeSuccessPopup();
                }, 1000);
            }

            if (errorPopup) {
                errorPopup.classList.remove('pointer-events-none', 'opacity-0');
                errorPopup.classList.add('opacity-100');

                setTimeout(() => {
                    closeErrorPopup();
                }, 1000);
            }

            function closeSuccessPopup() {
                successPopup.classList.remove('opacity-100');
                successPopup.classList.add('opacity-0');
                setTimeout(() => {
                    successPopup.classList.add('pointer-events-none');
                }, 500);
            }

            function closeErrorPopup() {
                errorPopup.classList.remove('opacity-100');
                errorPopup.classList.add('opacity-0');
                setTimeout(() => {
                    errorPopup.classList.add('pointer-events-none');
                }, 500);
            }

            function openForm() {
                ajukanPeminjaman.classList.remove('pointer-events-none', 'opacity-0');
                ajukanPeminjaman.classList.add('opacity-100');
                formContent.classList.remove('-translate-y-full');
                formContent.classList.add('translate-y-0');
            }

            function closeForm() {
                formContent.classList.remove('translate-y-0');
                formContent.classList.add('-translate-y-full');
                ajukanPeminjaman.classList.remove('opacity-100');
                ajukanPeminjaman.classList.add('opacity-0');
                setTimeout(() => {
                    ajukanPeminjaman.classList.add('pointer-events-none');
                }, 500);
            }
        </script>
    </div>

@endsection
