@extends('layout.lokasi')

@section('title', 'lokasi')

@section('content')
<div class="bg-gray-100 font-poppins leading-normal tracking-normal">
    <!-- Main content -->
    <div class="w-full p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-widest">HALO LABORAN</h1>
        <p class="text-gray-600 mb-8 tracking-wide">Selamat Datang di Halaman Data Lokasi</p>

        <!-- Tombol Tambah Data lokasi -->
        <a href="javascript:void(0)" onclick="openForm()" class="bg-blue-300 hover:bg-blue-600 text-white flex items-center justify-center h-[40px] w-[170px] font-bold rounded-lg mb-4 shadow-md transition duration-300">
            <span class="material-symbols-outlined text-[20px] mr-1">add</span>
            <p class="text-[15px]">Tambah Lokasi</p>
        </a>

        <!-- Tabel Daftar lokasi -->
        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-sm mb-8">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300 text-black">
                        <th class="py-3 px-4 font-bold text-center rounded-tl-lg">No</th>
                        <th class="py-3 px-4 font-bold text-center">Lokasi</th>
                        <th class="py-3 px-4 font-bold text-center rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $index => $data)
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 text-center">{{ $data->lokasi }}</td>
                        <td class="py-2 border-t border-gray-300">
                            <div class="flex items-center justify-center font-semibold h-1 text-center">
                                <button class="bg-green-400 hover:bg-green-600 mr-2 rounded-md p-1 w-[80px]" onclick="openEditForm('{{ $data->lokasi }}', '{{ $data->id }}')">EDIT</button>
                                <form action="{{ route('lokasi.destroy', $data->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-400 hover:bg-red-600 rounded-md mt-4 p-1 w-[80px]">HAPUS</button>
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

<!-- Form Tambah Lokasi -->
<div id="tambah-lokasi" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
    <div class="bg-white w-1/2 p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500">
        <h2 class="text-xl font-bold mb-4">Tambah Lokasi</h2>
        <form action="{{ route('lokasi.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Lokasi</label>
                <input type="text" name="lokasi" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan lokasi" required />
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2" onclick="closeForm()">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Form Edit Lokasi -->
<div id="edit-lokasi" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
    <div class="bg-white w-1/2 p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500">
        <h2 class="text-xl font-bold mb-4">Edit Lokasi</h2>
        <form id="editForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Lokasi</label>
                <input type="text" name="lokasi" class="w-full px-3 py-2 border rounded-lg" id="editLokasi" placeholder="Masukkan lokasi" required />
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
    const tambahLokasi = document.getElementById('tambah-lokasi');
    const formContent = tambahLokasi.querySelector('div');

    function openForm() {
        tambahLokasi.classList.remove('pointer-events-none', 'opacity-0');
        tambahLokasi.classList.add('opacity-100');
        formContent.classList.remove('-translate-y-full');
        formContent.classList.add('translate-y-0');
    }

    function closeForm() {
        formContent.classList.remove('translate-y-0');
        formContent.classList.add('-translate-y-full');
        tambahLokasi.classList.remove('opacity-100');
        tambahLokasi.classList.add('opacity-0');
        setTimeout(() => {
            tambahLokasi.classList.add('pointer-events-none');
        }, 500);
    }

    const editLokasi = document.getElementById('edit-lokasi');
    const editFormContent = editLokasi.querySelector('div');



    function openEditForm(lokasi, id) {
        // Set nilai input lokasi
        document.getElementById('editLokasi').value = lokasi;

        // Set action form dengan id yang diterima
        const editForm = document.getElementById('editForm');
        editForm.action = `/lokasi/${id}`;

        // Tampilkan form edit
        editLokasi.classList.remove('pointer-events-none', 'opacity-0');
        editLokasi.classList.add('opacity-100');
        editFormContent.classList.remove('-translate-y-full');
        editFormContent.classList.add('translate-y-0');
    }


    function closeEditForm() {
        editFormContent.classList.remove('translate-y-0');
        editFormContent.classList.add('-translate-y-full');
        editLokasi.classList.remove('opacity-100');
        editLokasi.classList.add('opacity-0');
        setTimeout(() => {
            editLokasi.classList.add('pointer-events-none');
        }, 500);
    }
</script>
@endsection
