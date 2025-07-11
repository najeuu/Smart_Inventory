@extends('layout.data_barang')

@section('title', 'Data Barang')

@section('content')
    @push('scripts')
        <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
<script>
    const socket = io("http://localhost:8000"); // Ganti dengan IP Python server jika tidak di localhost

    socket.on("connect", () => {
        console.log("✅ Tersambung ke WebSocket server RFID");
    });

    socket.on("tag_scanned", function (data) {
        const inputRFID = document.getElementById("kodeRFID");
        if (inputRFID) {
            inputRFID.value = data.tag_uid;
            console.log("🏷️ Tag diterima:", data.tag_uid);
        }
    });

    socket.on("disconnect", () => {
        console.warn("⚠️ Koneksi ke server RFID terputus");
    });
</script>
    @endpush
    <div class="bg-gray-100 font-poppins leading-normal tracking-normal">
        <!-- Main content -->
        <div class="w-full p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">DATA BARANG</h1>

            <!-- Tombol Tambah Data Barang -->
            <a href="#" onclick="event.preventDefault(); openForm()"
                class="bg-blue-300 hover:bg-blue-600 text-white flex items-center justify-center h-[40px] w-[200px] font-bold rounded-lg mb-4 shadow-md transition duration-300">
                <span class="material-symbols-outlined text-[20px] mr-1">add</span>
                <p class="text-[15px]">Tambah Data Barang</p>
            </a>
            @if (session('success'))
                <div class="bg-green-500 text-white font-semibold px-6 py-4 rounded shadow mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('kode_rfid_terdaftar'))
                <div class="w-full bg-red-500 text-white font-semibold px-6 py-4 rounded shadow mb-4">
                    {{ session('kode_rfid_terdaftar') }}
                </div>
            @endif

            @if ($errors->has('kode_rfid'))
                <div class="w-full bg-red-500 text-white font-semibold px-6 py-4 rounded shadow mb-4">
                    {{ $errors->first('kode_rfid') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500 text-white font-semibold px-6 py-4 rounded shadow mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Tabel Daftar Barang -->
            <div class="overflow-x-auto rounded-lg border border-gray-300 shadow-sm mb-8">
            <table class="min-w-full divide-y divide-gray-300">
                <thead class="bg-blue-300 text-black">
                    <tr>
                        <th class="py-3 px-4 text-center font-bold">No</th>
                        <th class="py-3 px-4 text-left font-bold">Nama Barang</th>
                        <th class="py-3 px-4 text-center font-bold">Jumlah</th>
                        <th class="py-3 px-4 text-center font-bold">Kategori</th>
                        <th class="py-3 px-4 text-center font-bold">Lokasi</th>
                        <th class="py-3 px-4 text-center font-bold">Deskripsi</th>
                        <th class="py-3 px-4 text-center font-bold">Gambar</th>
                        <th class="py-3 px-4 text-center font-bold">Kode RFID</th>
                        <th class="py-3 px-4 text-center font-bold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if ($data->count() === 0)
                <tr>
                    <td colspan="9" class="text-center py-6 text-gray-500 font-semibold">
                        Belum ada data barang
                    </td>
                </tr>
                    @else
                    @foreach ($data as $index => $barang)
                        <tr class="hover:bg-gray-100 transition duration-200">
                            <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">{{ $barang->nama_barang }}</td>
                            <td class="py-3 px-4 text-center">{{ $barang->jumlah }}</td>
                            <td class="py-3 px-4 text-center">{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                            <td class="py-3 px-4 text-center">{{ $barang->lokasi->lokasi }}</td>
                            <td class="py-3 px-4 text-sm text-center break-words max-w-xs">
                                {{ $barang->deskripsi ?? '-' }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if ($barang->gambar)
                                    <img src="{{ asset('storage/' . $barang->gambar) }}"
                                        alt="Gambar Barang"
                                        class="w-12 h-12 object-cover rounded shadow border border-gray-300 mx-auto">
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">{{ $barang->kode_rfid }}</td>
                            <td class="py-3 px-4 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <!-- Tombol Edit -->
                                <button type="button"
                                    class="flex items-center justify-center w-[70px] h-[36px] bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-md shadow transition duration-200"
                                    onclick="openEditForm(
                                        '{{ $barang->nama_barang }}',
                                        '{{ $barang->jumlah }}',
                                        '{{ $barang->lokasi_id }}',
                                        '{{ $barang->kode_rfid }}',
                                        '{{ $barang->id }}',
                                        '{{ $barang->kategori_id }}',
                                        `{{ $barang->deskripsi ?? '' }}`,
                                        `{{ $barang->gambar ?? '' }}`
                                    )">
                                    EDIT
                                </button>

                                <!-- Tombol Hapus -->
                                <form id="delete-form-{{ $barang->id }}"
                                    action="{{ route('barang.destroy', $barang->id) }}"
                                    method="POST"
                                    class="m-0 p-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="confirmDelete({{ $barang->id }})"
                                        class="flex items-center justify-center w-[70px] h-[36px] bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-md shadow transition duration-200">
                                        HAPUS
                                    </button>
                                </form>
                            </div>
                        </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $data->links('vendor.pagination.tailwind') }}
            </div>

        </div>
    </div>

    <!-- Form Tambah Barang -->
    <div id="form-barang" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="bg-white w-1/2 max-h-screen overflow-y-auto p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500">
            <h2 class="text-xl font-bold mb-4">Tambah Barang</h2>
            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
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
                        <input type="text" name="kode_rfid" id="kodeRFID"
                            class="w-full px-3 py-2 border rounded-lg"
                            placeholder="Scan Tag RFID" readonly required />
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
            <form id="editForm" action="" method="POST" enctype="multipart/form-data">
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
                    <img id="previewGambar" src="" alt="Preview Gambar" class="mt-2 rounded w-32 hidden">
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
<script type="text/javascript">
    // === Fungsi Modal ===
    window.openForm = function () {
    const modal = document.getElementById('form-barang');
    const modalContent = modal.querySelector('div');
    modal.classList.remove('pointer-events-none', 'opacity-0');
    modal.classList.add('opacity-100');
    modalContent.classList.remove('-translate-y-full');
    modalContent.classList.add('translate-y-0');
    modal.querySelector('form').reset();
    const rfidInput = document.getElementById('kodeRFID');
    if (rfidInput) rfidInput.value = '';
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

    window.openEditForm = function (nama, jumlah, lokasiId, kodeRFID, id, kategoriId, deskripsi = '', gambar = '') {
        const form = document.getElementById('editForm');
        console.log({ deskripsi, gambar });
        form.action = `/data_barang/${id}`;

        document.getElementById('editNamaBarang').value = nama;
        document.getElementById('editJumlah').value = jumlah;
        document.getElementById('newRFID').value = kodeRFID;
        document.getElementById('editLokasi').value = lokasiId;
        document.getElementById('editKategori').value = kategoriId;
        document.getElementById('editDeskripsi').value = deskripsi;

        const preview = document.getElementById('previewGambar');
        if (gambar && preview) {
            preview.src = `/storage/${gambar}`;
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }

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

<script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const inputRFID = document.getElementById("kodeRFID");
    const socket = io("http://localhost:8000");

    socket.on("connect", () => {
        console.log("✅ Tersambung ke server RFID");
    });

    socket.on("tag_scanned", (data) => {
    const isTambahOpen = document.getElementById("form-barang").classList.contains("opacity-100");
    const isEditOpen = document.getElementById("edit-barang").classList.contains("opacity-100");

    if (isTambahOpen) {
        const inputRFID = document.getElementById("kodeRFID");
        if (inputRFID) inputRFID.value = data.tag_uid;
    } else if (isEditOpen) {
        const inputEditRFID = document.getElementById("newRFID");
        if (inputEditRFID) inputEditRFID.value = data.tag_uid;
    }

    console.log("🏷️ Tag diterima:", data.tag_uid);
});

    socket.on("disconnect", () => {
        console.warn("⚠️ Terputus dari server RFID");
    });

    socket.on("connect_error", (err) => {
        console.error("❌ Gagal koneksi ke server RFID:", err.message);
    });
});
</script>

@endpush
@endsection

