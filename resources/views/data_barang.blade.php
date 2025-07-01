@extends('layout.data_barang')

@section('title', 'Data Barang')

@section('content')
    @push('scripts')
        <script src="{{ asset('js/reader.js') }}" type="module"></script>
        <script src="{{ asset('js/rfid-scanner.js') }}" type="module"></script>
    @endpush
    <div class="bg-gray-100 font-poppins leading-normal tracking-normal">
        <!-- Main content -->
        <div class="w-full p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-widest">HALO LABORAN</h1>
            <p class="text-gray-600 mb-8 tracking-wide">Selamat Datang di Halaman Data Barang</p>

            <!-- Tombol Tambah Data Barang -->
            <a href="#" onclick="event.preventDefault(); openForm()"
                class="bg-blue-300 hover:bg-blue-600 text-white flex items-center justify-center h-[40px] w-[200px] font-bold rounded-lg mb-4 shadow-md transition duration-300">
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
                        <tr class="bg-blue-300 text-black">
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
                                            onclick="openEditForm(
                                                '{{ $barang->nama_barang }}',
                                                '{{ $barang->jumlah }}',
                                                '{{ $barang->lokasi_id }}',
                                                '{{ $barang->kode_rfid }}',
                                                '{{ $barang->id }}',
                                                '{{ $barang->kategori_id }}'
                                            )">
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
    <div id="form-barang" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="bg-white w-1/2 max-h-screen overflow-y-auto p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500">
            <h2 class="text-xl font-bold mb-4">Tambah Barang</h2>
            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Nama Barang</label>
                    <input type="text" name="nama_barang" class="w-full px-3 py-2 border rounded-lg" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Jumlah</label>
                    <input type="number" name="jumlah" class="w-full px-3 py-2 border rounded-lg" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kategori</label>
                    <select name="kategori_id" class="w-full px-3 py-2 border rounded-lg" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full px-3 py-2 border rounded-lg" rows="3"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Gambar</label>
                    <input type="file" name="gambar" class="w-full px-3 py-2 border rounded-lg" accept="image/*">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Lokasi</label>
                    <select name="lokasi_id" class="w-full px-3 py-2 border rounded-lg" required>
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach ($lokasi as $lokasiItem)
                            <option value="{{ $lokasiItem->id }}">{{ $lokasiItem->lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
    <label class="block text-gray-700 font-medium mb-2">Kode RFID</label>
    <div class="flex gap-2">
        <input type="text" name="kode_rfid" class="w-full px-3 py-2 border rounded-lg" id="createRFID" readonly>
        <button type="button" id="startScanCreate" class="bg-blue-400 px-3 py-2 rounded text-white">Scan RFID</button>
    </div>
</div>
                <div class="flex justify-end">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2" onclick="closeForm()">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Form Edit Barang -->
    <div id="edit-barang" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="bg-white w-1/2 max-h-screen overflow-y-auto p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500">
            <h2 class="text-xl font-bold mb-4">Edit Barang</h2>
            <form id="editForm" action="/data_barang/{{ $barang->id }}" method="POST">
    @csrf
    @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Nama Barang</label>
                    <input type="text" name="nama_barang" class="w-full px-3 py-2 border rounded-lg" id="editNamaBarang" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Jumlah</label>
                    <input type="number" name="jumlah" class="w-full px-3 py-2 border rounded-lg" id="editJumlah" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kategori</label>
                    <select name="kategori_id" class="w-full px-3 py-2 border rounded-lg" id="editKategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                    <textarea name="deskripsi" id="editDeskripsi" class="w-full px-3 py-2 border rounded-lg" rows="3"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Gambar</label>
                    <input type="file" name="gambar" class="w-full px-3 py-2 border rounded-lg" accept="image/*">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Lokasi</label>
                    <select name="lokasi_id" id="editLokasi" class="w-full px-3 py-2 border rounded-lg" required>
                        <option value="">-- Pilih Lokasi --</option>
                        @foreach ($lokasi as $lokasiItem)
                            <option value="{{ $lokasiItem->id }}">{{ $lokasiItem->lokasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
    <label class="block text-gray-700 font-medium mb-2">Kode RFID</label>
    <div class="flex gap-2">
        <input type="text" name="kode_rfid" class="w-full px-3 py-2 border rounded-lg" id="newRFID" readonly>
        <button type="button" id="startScanRFID" class="bg-blue-400 px-3 py-2 rounded text-white">Scan RFID</button>
    </div>
</div>
                <div class="flex justify-end">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2" onclick="closeEditForm()">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
<script type="module">
    import { RFIDScanner } from '/js/rfid-scanner-laravel.js';

    document.addEventListener('DOMContentLoaded', () => {
        console.log("DOM loaded, initializing scanners...");

        // === Scan Tambah Data ===
        const createScanButton = document.getElementById('startScanCreate');
        const createRFIDInput = document.getElementById('createRFID');
        if (createScanButton && createRFIDInput) {
            const createScanner = new RFIDScanner(createRFIDInput);
            createScanButton.addEventListener('click', async () => {
                console.log("Scanning for Tambah...");
                if (await createScanner.openPort()) {
                    const result = await createScanner.startScanning();
                    if (!result) alert('Tag gagal dibaca atau sudah terdaftar.');
                    await createScanner.closePort();
                } else {
                    alert('Gagal membuka port serial.');
                }
            });
        }

        // === Scan Edit Data ===
        const editScanButton = document.getElementById('startScanRFID');
        const editRFIDInput = document.getElementById('newRFID');
        if (editScanButton && editRFIDInput) {
            const editScanner = new RFIDScanner(editRFIDInput);
            editScanButton.addEventListener('click', async () => {
                console.log("Scanning for Edit...");
                if (await editScanner.openPort()) {
                    const result = await editScanner.startScanning();
                    if (!result) alert('Tag gagal dibaca atau sudah terdaftar.');
                    await editScanner.closePort();
                } else {
                    alert('Gagal membuka port serial.');
                }
            });
        }
    });
</script>

<script type="text/javascript">
    // === Fungsi Modal ===
    window.openForm = function () {
        const modal = document.getElementById('form-barang');
        const modalContent = modal.querySelector('div');
        modal.classList.remove('pointer-events-none', 'opacity-0');
        modal.classList.add('opacity-100');
        modalContent.classList.remove('-translate-y-full');
        modalContent.classList.add('translate-y-0');
    }

    window.closeForm = function () {
        const modal = document.getElementById('form-barang');
        const modalContent = modal.querySelector('div');
        modalContent.classList.remove('translate-y-0');
        modalContent.classList.add('-translate-y-full');
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('pointer-events-none');
        }, 500);
    }

    window.openEditForm = function (nama, jumlah, lokasiId, kodeRFID, id, kategoriId) {
        const form = document.getElementById('editForm');
        form.action = `/data_barang/${id}`;

        document.getElementById('editNamaBarang').value = nama;
        document.getElementById('editJumlah').value = jumlah;
        document.getElementById('newRFID').value = kodeRFID;
        document.getElementById('editLokasi').value = lokasiId;
        document.getElementById('editKategori').value = kategoriId;

        const modal = document.getElementById('edit-barang');
        const modalContent = modal.querySelector('div');
        modal.classList.remove('pointer-events-none', 'opacity-0');
        modal.classList.add('opacity-100');
        modalContent.classList.remove('-translate-y-full');
        modalContent.classList.add('translate-y-0');
    }

    window.closeEditForm = function () {
        const modal = document.getElementById('edit-barang');
        const modalContent = modal.querySelector('div');
        modalContent.classList.remove('translate-y-0');
        modalContent.classList.add('-translate-y-full');
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('pointer-events-none');
        }, 500);
    }

    window.confirmDelete = function (id) {
        if (confirm('Yakin ingin menghapus barang ini?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endpush
@endsection

