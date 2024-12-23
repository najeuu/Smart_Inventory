@extends('layout.data_barang')

@section('title', 'Data Barang')

@section('content')
    <div class="bg-gray-100 font-poppins leading-normal tracking-normal">
        <!-- Main content -->
        <div class="w-full p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-widest">HALO LABORAN</h1>
            <p class="text-gray-600 mb-8 tracking-wide">Selamat Datang di Halaman Data Barang</p>

            <!-- Tombol Tambah Data Barang -->
            <a href="javascript:void(0)" onclick="openForm()"
                class="bg-orange-300 hover:bg-orange-600 text-white flex items-center justify-center h-[40px] w-[200px] font-bold rounded-lg mb-4 shadow-md transition duration-300">
                <span class="material-symbols-outlined text-[20px] mr-1">add</span>
                <p class="text-[15px]">Tambah Data Barang</p>
            </a>
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            <!-- Tabel Daftar Barang -->
            <div class="overflow-hidden rounded-lg border border-gray-300 shadow-sm mb-8">
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr class="bg-orange-300 text-black">
                            <th class="py-3 px-4 font-bold text-center rounded-tl-lg">No</th>
                            <th class="py-3 px-4 font-bold text-left">Nama Barang</th>
                            <th class="py-3 px-4 font-bold text-center">Jumlah</th>
                            <th class="py-3 px-4 font-bold text-center">Lokasi</th>
                            <th class="py-3 px-4 font-bold text-center">Kode RFID</th>
                            <th class="py-3 px-4 font-bold text-center rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $index => $barang)
                            <tr class="bg-white border-b hover:bg-gray-100">
                                <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 text-left">{{ $barang->nama_barang }}</td>
                                <td class="py-3 px-4 text-center">{{ $barang->jumlah }}</td>
                                <td class="py-3 px-4 text-center">{{ $barang->lokasi->lokasi }}</td>
                                <td class="py-3 px-4 text-center">{{ $barang->kode_rfid }}</td>
                                <td class="py-2 border-t border-gray-300">
                                    <div class="flex items-center justify-center font-semibold h-1 text-center">
                                        <button class="bg-green-400 hover:bg-green-600 mr-2 rounded-md p-1 w-[80px]"
                                            onclick="openEditForm('{{ $barang->nama_barang }}', '{{ $barang->jumlah }}', '{{ $barang->lokasi }}', '{{ $barang->kode_rfid }}', '{{ $barang->id }}')">
                                            EDIT
                                        </button>
                                        <form id="delete-form-{{ $barang->id }}"
                                            action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="bg-red-400 hover:bg-red-600 rounded-md mt-4 p-1 w-[80px]"
                                                onclick="confirmDelete('{{ $barang->id }}')">
                                                HAPUS
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form Tambah Barang -->
    <div id="tambah-barang"
        class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="bg-white w-1/2 p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500">
            <h2 class="text-xl font-bold mb-4">Tambah Barang</h2>
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <!-- Nama Barang -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Nama Barang</label>
                    <input type="text" name="nama_barang" class="w-full px-3 py-2 border rounded-lg"
                        placeholder="Masukkan nama barang" value="{{ old('nama_barang') }}" required />
                    @error('nama_barang')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Jumlah -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Jumlah</label>
                    <input type="number" name="jumlah" min="1" class="w-full px-3 py-2 border rounded-lg"
                        placeholder="Masukkan jumlah" value="{{ old('jumlah') }}" required />
                    @error('jumlah')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Lokasi -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Lokasi</label>
                    <select name="lokasi_id" class="w-full px-3 py-2 border rounded-lg" required>
                        <option value="">Pilih Lokasi</option>
                        @foreach ($lokasi as $lokasiItem)
                            <option value="{{ $lokasiItem->id }}"
                                {{ old('lokasi_id') == $lokasiItem->id ? 'selected' : '' }}>
                                {{ $lokasiItem->lokasi }}
                            </option>
                        @endforeach
                    </select>
                    @error('lokasi_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Kode RFID -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kode RFID</label>
                    <input type="text" name="kode_rfid" class="w-full px-3 py-2 border rounded-lg"
                        placeholder="Scan Tag RFID" value="{{ old('kode_rfid') }}" required />
                    @error('kode_rfid')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Tombol -->
                <div class="flex justify-end">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2"
                        onclick="closeForm()">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Form Edit Barang -->
    <div id="edit-barang"
        class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="bg-white w-1/2 p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500">
            <h2 class="text-xl font-bold mb-4">Edit Barang</h2>
            <form id="editForm" action="" method="POST">
                @csrf
                @method('PUT')
                <!-- Nama Barang -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Nama Barang</label>
                    <input type="text" name="nama_barang" class="w-full px-3 py-2 border rounded-lg" id="editNamaBarang"
                        placeholder="Masukkan nama barang" required />
                </div>
                <!-- Jumlah -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Jumlah</label>
                    <input type="number" name="jumlah" min="1" class="w-full px-3 py-2 border rounded-lg"
                        id="editJumlah" placeholder="Masukkan jumlah" required />
                    @error('jumlah')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <!-- Lokasi -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Lokasi</label>
                    <select name="lokasi_id" class="w-full px-3 py-2 border rounded-lg" id="editLokasi" required>
                        <option value="">Pilih Lokasi</option>
                        @foreach ($lokasi as $lokasiItem)
                            <option value="{{ $lokasiItem->id }}"
                                {{ old('lokasi_id') == $lokasiItem->id ? 'selected' : '' }}>
                                {{ $lokasiItem->lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Kode RFID -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kode RFID</label>
                    <input type="text" name="kode_rfid" class="w-full px-3 py-2 border rounded-lg" id="editKodeRFID"
                        placeholder="Scan Tag RFID" required />
                </div>
                <!-- Tombol -->
                <div class="flex justify-end">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2"
                        onclick="closeEditForm()">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Validasi input jumlah
        document.querySelector('[name="jumlah"]').addEventListener('input', function(e) {
            if (e.target.value <= 0) {
                alert('Jumlah barang harus lebih dari 0.');
                e.target.value = '';
            }
        });

        // Form Tambah Barang
        const tambahBarang = document.getElementById('tambah-barang');
        const formContent = tambahBarang.querySelector('div');

        function openForm() {
            tambahBarang.classList.remove('pointer-events-none', 'opacity-0');
            tambahBarang.classList.add('opacity-100');
            formContent.classList.remove('-translate-y-full');
            formContent.classList.add('translate-y-0');
        }

        function closeForm() {
            formContent.classList.remove('translate-y-0');
            formContent.classList.add('-translate-y-full');
            tambahBarang.classList.remove('opacity-100');
            tambahBarang.classList.add('opacity-0');
            setTimeout(() => {
                tambahBarang.classList.add('pointer-events-none');
            }, 500);
        }

        // Form Edit Barang
        const editBarang = document.getElementById('edit-barang');
        const editFormContent = editBarang.querySelector('div');

        function openEditForm(nama, jumlah, lokasi, kodeRFID, id) {
            // Set nilai pada form edit
            document.getElementById('editNamaBarang').value = nama;
            document.getElementById('editJumlah').value = jumlah;
            document.getElementById('editLokasi').value = lokasi; // Dropdown lokasi
            document.getElementById('editKodeRFID').value = kodeRFID;

            // Set action form dengan ID barang
            const editForm = document.getElementById('editForm');
            editForm.action = `/data_barang/${id}`;

            // Tampilkan form edit
            editBarang.classList.remove('pointer-events-none', 'opacity-0');
            editBarang.classList.add('opacity-100');
            editFormContent.classList.remove('-translate-y-full');
            editFormContent.classList.add('translate-y-0');
        }

        function closeEditForm() {
            // Tutup form edit
            editFormContent.classList.remove('translate-y-0');
            editFormContent.classList.add('-translate-y-full');
            editBarang.classList.remove('opacity-100');
            editBarang.classList.add('opacity-0');
            setTimeout(() => {
                editBarang.classList.add('pointer-events-none');
            }, 500);
        }

        // Konfirmasi Hapus
        function confirmDelete(id) {
            const confirmed = confirm("Apakah Anda yakin ingin menghapus data ini?");
            if (confirmed) {
                // Submit form jika pengguna menekan OK
                document.getElementById(`delete-form-${id}`).submit();
            }
            // Tidak ada tindakan jika pengguna menekan Cancel
        }
    </script>
@endsection
