@extends('layout.data_barang')

@section('title.Data Barang')

@section('content')

    <div class=" w-screen flex bg-gray-100 flex-box overflow-visible">
        <!-- main conten -->
        <div class="w-full flex flex-col mx-10 bg-gray-100 font-poppins pb-[30px]">
            <div class="pb-[30px] pt-[30px]">
                <p class="font-bold text-[25pt] tracking-widest">HALO LABORAN</p>
                <p class="mt-[-5px] tracking-wide">Selamat Datang di Halaman Data Barang</p>
            </div>

            <div class="bg-gray-200 bg-opacity-90 p-3 rounded-lg shadow-lg">
                <!-- Tombol -->
                <a href="javascript:void(0)" onclick="openForm()" class="bg-orange-300 hover:bg-orange-600 text-white flex items-center justify-center h-[35px] px-2 w-[135px] font-bold rounded-full mb-4 shadow-md transition duration-300">
                    <span class="material-symbols-outlined">add</span>
                    <p class="text-[12px]">Tambah Data</p>
                </a>
                <!-- Tabel -->
                <div class="overflow-hidden rounded-lg">
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="bg-orange-300 text-white">
                                <th class="py-2 font-bold text-center rounded-tl-lg">No</th>
                                <th class="px-2 py-3 font-bold text-left">Nama Barang</th>
                                <th class="py-2 font-bold text-center">Jumlah</th>
                                <th class="px-2 py-3 font-bold text-center rounded-tr-lg">Lokasi</th>
                                <th class="px-2 py-3 font-bold text-center rounded-tr-lg">Kode RFID</th>
                                <th class="py-2 font-bold text-center rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-orange-50">
                            <tr class="hover:bg-orange-100 transition duration-200">
                                <td class="py-2 border-t border-gray-300 text-center">1</td>
                                <td class="px-2 py-3 border-t text-left border-gray-300">Barang A</td>
                                <td class="py-2 border-t border-gray-300 text-center">10</td>
                                <td class="px-2 py-3 border-t border-gray-300 text-center">Gudang 1</td>
                                <td class="px-2 py-3 border-t border-gray-300 text-center">128939</td>
                                <td class="py-2 border-t border-gray-300">
                                    <div class="flex items-center justify-center font-semibold h-1 text-center">
                                        <button class="bg-green-400 hover:bg-green-600 mr-2 rounded-md p-1 w-[80px]" onclick="openEditForm('Barang A', 10, 'Gudang 1', '128939')">EDIT</button>
                                        <button class="bg-red-400 hover:bg-red-600 rounded-md p-1 w-[80px]">HAPUS</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-orange-100 transition duration-200">
                                <td class="py-2 border-t border-gray-300 text-center">1</td>
                                <td class="px-2 py-3 border-t text-left border-gray-300">Barang A</td>
                                <td class="py-2 border-t border-gray-300 text-center">10</td>
                                <td class="px-2 py-3 border-t border-gray-300 text-center">Gudang 1</td>
                                <td class="px-2 py-3 border-t border-gray-300 text-center">128939</td>
                                <td class="py-2 border-t border-gray-300">
                                    <div class="flex items-center justify-center font-semibold h-1 text-center">
                                        <button class="bg-green-400 hover:bg-green-600 mr-2 rounded-md p-1 w-[80px]" onclick="openEditForm('Barang A', 10, 'Gudang 1', '128939')">EDIT</button>
                                        <button class="bg-red-400 hover:bg-red-600 rounded-md p-1 w-[80px]">HAPUS</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-orange-100 transition duration-200">
                                <td class="py-2 border-t border-gray-300 text-center">1</td>
                                <td class="px-2 py-3 border-t text-left border-gray-300">Barang A</td>
                                <td class="py-2 border-t border-gray-300 text-center">10</td>
                                <td class="px-2 py-3 border-t border-gray-300 text-center">Gudang 1</td>
                                <td class="px-2 py-3 border-t border-gray-300 text-center">128939</td>
                                <td class="py-2 border-t border-gray-300">
                                    <div class="flex items-center justify-center font-semibold h-1 text-center">
                                        <button class="bg-green-400 hover:bg-green-600 mr-2 rounded-md p-1 w-[80px]" onclick="openEditForm('Barang A', 10, 'Gudang 1', '128939')">EDIT</button>
                                        <button class="bg-red-400 hover:bg-red-600 rounded-md p-1 w-[80px]">HAPUS</button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-orange-100 transition duration-200">
                                <td class="py-2 border-t border-gray-300 text-center">1</td>
                                <td class="px-2 py-3 border-t text-left border-gray-300">Barang A</td>
                                <td class="py-2 border-t border-gray-300 text-center">10</td>
                                <td class="px-2 py-3 border-t border-gray-300 text-center">Gudang 1</td>
                                <td class="px-2 py-3 border-t border-gray-300 text-center">128939</td>
                                <td class="py-2 border-t border-gray-300">
                                    <div class="flex items-center justify-center font-semibold h-1 text-center">
                                        <button class="bg-green-400 hover:bg-green-600 mr-2 rounded-md p-1 w-[80px]" onclick="openEditForm('Barang A', 10, 'Gudang 1', '128939')">EDIT</button>
                                        <button class="bg-red-400 hover:bg-red-600 rounded-md p-1 w-[80px]">HAPUS</button>
                                    </div>
                                </td>
                            </tr>
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
            <form>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Nama Barang</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan nama barang" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Jumlah</label>
                    <input type="number" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan jumlah" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Lokasi</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan lokasi" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kode RFID</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg" placeholder="Scan Tag RFID" />
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
            <form id="editForm">
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Nama Barang</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg" id="editNamaBarang" placeholder="Masukkan nama barang" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Jumlah</label>
                    <input type="number" class="w-full px-3 py-2 border rounded-lg" id="editJumlah" placeholder="Masukkan jumlah" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Lokasi</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg" id="editLokasi" placeholder="Masukkan lokasi" />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Kode RFID</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg" id="editKodeRFID" placeholder="Scan Tag RFID" />
                </div>
                <div class="flex justify-end">
                    <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2" onclick="closeEditForm()">Batal</button>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>


    <!-- JavaScript -->
    <script>
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


        const editBarang = document.getElementById('edit-barang');
        const editFormContent = editBarang.querySelector('div');

        function openEditForm(nama, jumlah, lokasi, kodeRFID) {
            // Isi form dengan data yang akan diedit
            document.getElementById('editNamaBarang').value = nama;
            document.getElementById('editJumlah').value = jumlah;
            document.getElementById('editLokasi').value = lokasi;
            document.getElementById('editKodeRFID').value = kodeRFID;

            editBarang.classList.remove('pointer-events-none', 'opacity-0');
            editBarang.classList.add('opacity-100');
            editFormContent.classList.remove('-translate-y-full');
            editFormContent.classList.add('translate-y-0');
        }

        function closeEditForm() {
            editFormContent.classList.remove('translate-y-0');
            editFormContent.classList.add('-translate-y-full');
            editBarang.classList.remove('opacity-100');
            editBarang.classList.add('opacity-0');
            setTimeout(() => {
                editBarang.classList.add('pointer-events-none');
            }, 500);
        }
    </script>

@endsection

