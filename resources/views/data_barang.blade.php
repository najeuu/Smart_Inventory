@extends('layout.data_barang')

@section('title', 'Data Barang')

@section('content')
    <div class="w-screen flex bg-gray-100 overflow-visible">
        <div class="w-full flex flex-col mx-10 bg-gray-100 font-poppins pb-30">
            <div class="pb-30 pt-30">
                <p class="font-bold text-25 tracking-widest">HALO LABORAN</p>
                <p class="mt-[-5px] tracking-wide">Selamat Datang di Halaman Data Barang</p>
            </div>

            <div class="bg-gray-200 bg-opacity-90 p-3 rounded-lg shadow-lg">
                <button onclick="openForm()" class="bg-orange-300 hover:bg-orange-600 text-white flex items-center justify-center h-35px px-2 w-135px font-bold rounded-full mb-4 shadow-md transition duration-300">
                    <span class="material-symbols-outlined">add</span> Tambah Barang
                </button>

                <div class="overflow-hidden rounded-lg">
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="bg-orange-300 text-white">
                                <th class="py-2 font-bold text-center rounded-tl-lg">No</th>
                                <th class="px-2 py-3 font-bold text-left">Nama Barang</th>
                                <th class="py-2 font-bold text-center">Jumlah</th>
                                <th class="px-2 py-3 font-bold text-center">Lokasi</th>
                                <th class="px-2 py-3 font-bold text-center">Kode RFID</th>
                                <th class="py-2 font-bold text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-orange-50">
                            @foreach($data as $barang => $item)
                                <tr class="hover:bg-orange-100 transition duration-200">
                                    <td class="py-2 border-t border-gray-300 text-center">{{ $index + 1 }}</td>
                                    <td class="px-2 py-3 border-t text-left border-gray-300">{{ $barang->nama_barang }}</td>
                                    <td class="py-2 border-t border-gray-300 text-center">{{ $barang->jumlah }}</td>
                                    <td class="px-2 py-3 border-t border-gray-300 text-center">{{ $barang->lokasi }}</td>
                                    <td class="px-2 py-3 border-t border-gray-300 text-center">{{ $barang->kode_rfid }}</td>
                                    <td class="py-2 border-t border-gray-300">
                                        <div class="flex items-center justify-center font-semibold h-1 text-center">
                                            <button class="bg-green-400 hover:bg-green-600 mr-2 rounded-md p-1 w-80px" onclick="openEditForm('{{ $item->nama_barang }}', '{{ $item->jumlah }}', '{{ $item->lokasi }}', '{{ $item->kode_rfid }}')">EDIT</button>
                                            <form action="{{ route('barang.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-400 hover:bg-red-600 rounded-md p-1 w-80px">HAPUS</button>
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
    </div>

    <!-- Form Tambah Barang -->
    <div id="tambah-barang" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="bg-white w-1/2 p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500">
            <h2 class="text-xl font-bold mb-4">Tambah Barang</h2>
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Nama Barang</label>
                    <input type="text" name="nama_barang" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan nama barang" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Jumlah</label>
                    <input type="number" name="jumlah" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan jumlah" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Lokasi</label>
                    <input type="text" name="lokasi" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan lokasi" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kode RFID</label>
                    <input type="text" name="kode_rfid" class="w-full px-3 py-2 border rounded-lg" placeholder="Scan Tag RFID" required />
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2" onclick="closeForm()">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Form Edit Barang -->
    <div id="edit-barang" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="bg-white w-1/2 p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500">
            <h2 class="text-xl font-bold mb-4">Edit Barang</h2>
            <form id="editForm" action="{{ route('barang.update', '') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Nama Barang</label>
                    <input type="text" id="editNamaBarang" name="nama_barang" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan nama barang" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Jumlah</label>
                    <input type="number" id="editJumlah" name="jumlah" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan jumlah" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Lokasi</label>
                    <input type="text" id="editLokasi" name="lokasi" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan lokasi" required />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kode RFID</label>
                    <input type="text" id="editKodeRFID" name="kode_rfid" class="w-full px-3 py-2 border rounded-lg" placeholder="Scan Tag RFID" required />
                </div>
                <input type="hidden" id="editId" name="id" />
                <div class="flex justify-end">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2" onclick="closeEditForm()">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openForm() {
            document.getElementById('tambah-barang').style.opacity = 1;
            document.getElementById('tambah-barang').style.pointerEvents = 'auto';
        }
        
        function closeForm() {
            document.getElementById('tambah-barang').style.opacity = 0;
            document.getElementById('tambah-barang').style.pointerEvents = 'none';
        }

        function openEditForm(nama, jumlah, lokasi, kode_rfid) {
            document.getElementById('editNamaBarang').value = nama;
            document.getElementById('editJumlah').value = jumlah;
            document.getElementById('editLokasi').value = lokasi;
            document.getElementById('editKodeRFID').value = kode_rfid;
            document.getElementById('editId').value = kode_rfid; // Make sure to use the correct ID to update
            document.getElementById('edit-barang').style.opacity = 1;
            document.getElementById('edit-barang').style.pointerEvents = 'auto';
        }
        
        function closeEditForm() {
            document.getElementById('edit-barang').style.opacity = 0;
            document.getElementById('edit-barang').style.pointerEvents = 'none';
        }
    </script>
@endsection
