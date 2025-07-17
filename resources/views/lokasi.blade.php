@extends('layout.lokasi')

@section('title', 'lokasi')

@section('content')

@if (session('success'))
    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold"></strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Gagal</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

<div class="min-h-screen overflow-y-auto bg-gray-100 font-poppins leading-normal tracking-normal">
    <!-- Main content -->
    <div class="w-full p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">LOKASI</h1>

        <!-- Tombol Tambah Data lokasi -->
        <a href="javascript:void(0)" onclick="openForm()" class="bg-blue-300 hover:bg-blue-500 text-white flex items-center justify-center h-10 w-44 font-semibold rounded-lg mb-4 shadow transition duration-300">
            <span class="material-symbols-outlined text-base mr-2">add</span>
            <span>Tambah Lokasi</span>
        </a>

        <!-- Tabel Daftar lokasi -->
        <div class="overflow-x-auto rounded-lg border border-gray-300 shadow-sm mb-8">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300 text-black">
                        <th class="py-3 px-4 font-bold text-center rounded-tl-lg">No</th>
                        <th class="py-3 px-4 font-bold text-center">Lokasi</th>
                        <th class="py-3 px-4 font-bold text-center rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $lokasi)
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 text-center">{{ $lokasi->lokasi }}</td>
                        <td class="py-2 border-t border-gray-300">
                            <div class="flex items-center justify-center font-semibold h-1 text-center">
                                <button class="bg-green-400 hover:bg-green-600 mr-2 rounded-md p-1 w-[80px]" onclick="openEditForm('{{ $lokasi->lokasi }}', '{{ $lokasi->id }}')">EDIT</button>
                                <form action="{{ route('lokasi.destroy', $lokasi->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus lokasi ini?')" class="bg-red-400 hover:bg-red-600 rounded-md mt-4 p-1 w-[80px]">
                                        HAPUS
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="py-4 text-center text-gray-500">
                            Data kategori belum tersedia. Silakan tambahkan data.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6 flex justify-center">
            {{ $data->links() }}
        </div>

        <!-- Filter & Search -->
        <div class="mb-6">
            <form method="GET" action="{{ route('lokasi') }}" class="flex flex-wrap md:flex-nowrap items-center gap-4 w-full border-transparent border p-6">
                <select name="filter_lokasi" class="px-3 py-2 border rounded-lg flex-grow w-full md:w-auto">
                    <option value="">-- Semua Lokasi --</option>
                    @foreach ($lokasiList as $lokasiItem)
                        <option value="{{ $lokasiItem->id }}" {{ $filterLokasi == $lokasiItem->id ? 'selected' : '' }}>
                            {{ $lokasiItem->lokasi }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama barang"
                    class="px-3 py-2 border rounded-lg flex-grow w-full md:w-auto" />

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg w-full md:w-auto">
                    Filter
                </button>
            </form>
        </div>

        <!-- Daftar Barang Berdasarkan Lokasi -->
        @if ($noBarangFound)
            <div class="text-center text-red-500 font-semibold mt-4 mb-6">
                Tidak ada data yang cocok dengan pencarian anda. Silahkan cari data lain
            </div>
        @endif

        @foreach ($data as $lokasi)
            @if($lokasi->barangs->count() > 0)
            <div class="mb-10">
                <h2 class="text-xl font-bold text-gray-800 mb-2">Barang di Lokasi: {{ $lokasi->lokasi }}</h2>
                <div class="overflow-x-auto rounded-lg border border-gray-300 shadow-sm">
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="bg-green-300 text-black">
                                <th class="py-3 px-4 font-bold text-center rounded-tl-lg">No</th>
                                <th class="py-3 px-4 font-bold text-center">Nama Barang</th>
                                <th class="py-3 px-4 font-bold text-center">Jumlah</th>
                                <th class="py-3 px-4 font-bold text-center rounded-tr-lg">Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lokasi->barangs as $index => $barang)
                            <tr class="bg-white border-b hover:bg-gray-100">
                                <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 text-center">{{ $barang->nama_barang }}</td>
                                <td class="py-3 px-4 text-center">{{ $barang->jumlah }}</td>
                                <td class="py-3 px-4 text-center">{{ $lokasi->lokasi }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>

<!-- Form Tambah Lokasi -->
<div id="tambah-lokasi" class="fixed top-0 left-0 w-full min-h-screen overflow-y-auto bg-gray-900 bg-opacity-50 z-50 flex justify-center items-start py-10 opacity-0 pointer-events-none transition-opacity duration-500">
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
<div id="edit-lokasi" class="fixed top-0 left-0 w-full min-h-screen overflow-y-auto bg-gray-900 bg-opacity-50 z-50 flex justify-center items-start py-10 opacity-0 pointer-events-none transition-opacity duration-500">
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
        document.getElementById('editLokasi').value = lokasi;
        document.getElementById('editForm').action = `/lokasi/${id}`;
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
