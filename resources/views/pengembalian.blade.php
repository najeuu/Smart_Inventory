@extends('layout.pengembalian')

@section('title', 'Pengembalian')

@section('content')
<div class="flex flex-col">

    @if(session('error'))
    <div id="notification" class="bg-red-500 text-white p-4 rounded-lg mb-4">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div id="notification" class="bg-green-500 text-white p-4 rounded-lg mb-4">
        {{ session('success') }}
    </div>
    @endif

    <!-- Mencari Data Mahasiswa -->
    <div class="mb-8 bg-orange-300 p-6 rounded-lg">
        <div class="max-w-xl">
            <label class="text-lg font-bold font-poppins">Cari Data Mahasiswa</label>
            <form action="{{ route('pengembalian.cari') }}" method="GET" class="mt-2 relative">
                <input type="text" name="nim" value="{{ old('nim', $nim ?? '') }}" placeholder="NIM" class="w-full px-4 font-poppins py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-300" required>
                <button type="submit" class="absolute right-3 top-2 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Menampilkan Data Peminjam -->
    @if (isset($nim))
    <div class="mb-8 bg-orange-300 p-6 rounded-lg">
        <h2 class="text-lg font-bold mb-4 font-poppins">PEMINJAM</h2>
        <div class="flex flex-wrap gap-2">
            <button class="px-4 py-2 bg-white font-poppins border border-gray-300 rounded-lg shadow hover:bg-orange-50"
                onclick="showTables()">
                {{ $nim }}
            </button>
        </div>
    </div>

    <div id="tablesContainer" style="display: none;">
        <div class="grid grid-cols-5 gap-8">
            <!-- Tabel Barang Yang Dipinjam -->
            <div class="col-span-2 bg-orange-300 rounded-lg shadow-md p-4">
                <h2 class="font-bold font-poppins mb-4 text-lg">Barang Yang Dipinjam</h2>
                <p class="font-poppins">NIM: {{ $nim }}</p>

                <div class="overflow-x-auto rounded-lg mb-4">
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="bg-white text-black">
                                <th class="py-3 font-bold text-center border-t border-gray-300 rounded-tl-lg font-poppins">No</th>
                                <th class="px-2 py-2 font-bold text-center border-t border-gray-300 font-poppins">Nama Barang</th>
                                <th class="py-3 font-bold text-center border-t border-gray-300 font-poppins">Total Barang</th>
                            </tr>
                        </thead>
                        <tbody class="bg-orange-50">
                            @forelse($barangDipinjam as $index => $barang)
                            <tr class="hover:bg-orange-100 transition duration-200 font-poppins">
                                <td class="py-2 px-4 text-center">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 text-center">{{ $barang['jenis_barang'] }}</td>
                                <td class="py-2 px-4 text-center">{{ $barang['total_barang'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">Tidak ada barang yang dipinjam.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel Hasil Scanner -->
            <div class="col-span-3 bg-orange-300 rounded-lg shadow-md p-4 mb-6">
                <h2 class="font-bold mb-6 text-lg">Hasil Scanner</h2>
                <div class="overflow-x-auto rounded-lg mb-4">
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="bg-white text-black">
                                <th class="py-3 font-bold text-center border-t border-gray-300">No</th>
                                <th class="px-2 py-2 font-bold text-center border-t border-gray-300">Nama Barang</th>
                                <th class="py-3 font-bold text-center border-t border-gray-300">Total Barang</th>
                                <th class="py-3 font-bold text-center border-t border-gray-300">Tanggal Pengembalian</th>
                            </tr>
                        </thead>
                        <tbody id="scannerTableBody" class="bg-orange-50"></tbody>
                    </table>
                </div>
                <button type="button" onclick="prosesPengembalian()" class="bg-green-500 text-white px-4 py-2 rounded-lg">
                    Proses
                </button>
            </div>
        </div>

        <!-- Form Pengembalian Barang -->
        <div id="formPengembalian" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
            <div class="bg-white w-1/2 p-5 rounded-lg shadow-lg transform translate-y-0 transition-transform duration-500">
                <h2 class="text-xl font-bold mb-4">Form Pengembalian Barang</h2>
                <form action="{{ route('pengembalian.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">NIM</label>
                        <input type="text" name="nim" class="w-full px-3 py-2 border rounded-lg" value="{{ $nim }}" required readonly />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Nama Barang</label>
                        <input type="text" name="nama_barang" class="w-full px-3 py-2 border rounded-lg" required />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Total Barang</label>
                        <input type="number" name="total_barang" class="w-full px-3 py-2 border rounded-lg" required />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Tanggal Pengembalian</label>
                        <input type="date" name="tanggal_pengembalian" class="w-full px-3 py-2 border rounded-lg" required />
                    </div>
                    <div class="flex justify-end">
                        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2" onclick="closeForm()">Batal</button>
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Cek jika ada error
        const errorMessage = "{{ $error ?? '' }}";
        if (errorMessage) {
            const popup = document.getElementById('errorPopup');
            popup.classList.remove('hidden');
            setTimeout(() => {
                popup.classList.add('hidden');
            }, 2000);
        }
    });

    // Menampilkan tabel 
    function showTables() {
        document.getElementById('tablesContainer').style.display = 'block';
    }

    function updateScannerTable(namaBarang, totalBarang, tanggalPengembalian) {
        const tableBody = document.getElementById('scannerTableBody');
        const row = document.createElement('tr');
        row.classList.add('hover:bg-orange-100');

        row.innerHTML = ` 
        <td class="py-2 px-4 text-center">${tableBody.children.length + 1}</td>
        <td class="py-2 px-4 text-center">${namaBarang}</td>
        <td class="py-2 px-4 text-center">${totalBarang}</td>
        <td class="py-2 px-4 text-center">${tanggalPengembalian}</td>
    `;
        tableBody.appendChild(row);
    }

    // Menampilkan form pengembalian
    function prosesPengembalian() {
        const formPengembalian = document.getElementById('formPengembalian');
        formPengembalian.classList.remove('pointer-events-none', 'opacity-0');
        formPengembalian.classList.add('opacity-100');
        formPengembalian.querySelector('div').classList.remove('translate-y-0');
        formPengembalian.querySelector('div').classList.add('translate-y-0');
    }

    function closeForm() {
        const formPengembalian = document.getElementById('formPengembalian');
        formPengembalian.classList.remove('opacity-100');
        formPengembalian.classList.add('opacity-0');
        formPengembalian.classList.add('pointer-events-none');
        formPengembalian.querySelector('div').classList.remove('translate-y-0');
        formPengembalian.querySelector('div').classList.add('translate-y-full');
    }
    document.getElementById('pengembalianForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const namaBarang = document.querySelector('input[name="nama_barang"]').value;
        const totalBarang = document.querySelector('input[name="total_barang"]').value;
        const tanggalPengembalian = document.querySelector('input[name="tanggal_pengembalian"]').value;

        updateScannerTable(namaBarang, totalBarang, tanggalPengembalian);

        closeForm();
    });
</script>
@endsection