@extends('layout.kategori')

@section('title', 'kategori')

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

<!-- Main content -->
    <div class="w-full p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">KATEGORI</h1>
        <!-- Tombol Tambah Kategori -->
        <a href="javascript:void(0)" onclick="openForm()" class="bg-blue-300 hover:bg-blue-600 text-white flex items-center justify-center h-[40px] w-[170px] font-bold rounded-lg mb-4 shadow-md transition duration-300">
            <span class="material-symbols-outlined text-[20px] mr-1">add</span>
            <p class="text-[15px]">Tambah Kategori</p>
        </a>

        <!-- Tabel Kategori -->
        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-sm mb-8">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300 text-black">
                        <th class="py-3 px-4 font-bold text-center rounded-tl-lg">No</th>
                        <th class="py-3 px-4 font-bold text-center">Nama Kategori</th>
                        <th class="py-3 px-4 font-bold text-center rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $kategori)
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 text-center">{{ $kategori->nama_kategori }}</td>
                        <td class="py-2 border-t border-gray-300">
                            <div class="flex items-center justify-center font-semibold h-1 text-center">
                                <button class="bg-green-400 hover:bg-green-600 mr-2 rounded-md p-1 w-[80px]" onclick="openEditForm('{{ $kategori->nama_kategori }}', '{{ $kategori->id }}')">EDIT</button>
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-400 hover:bg-red-600 rounded-md mt-4 p-1 w-[80px]">HAPUS</button>
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
    </div>
    <div class="mt-6 flex justify-center">
        {{ $data->links() }}
    </div>
</div>


<!-- Filter & Search -->
<div class="mb-6">
    <form method="GET" action="{{ route('kategori.index') }}" class="flex flex-wrap md:flex-nowrap items-center gap-4 w-full border-transparent border p-6">
        <select name="filter_kategori" class="px-3 py-2 border rounded-lg flex-grow w-full md:w-auto">
            <option value="">-- Semua Kategori --</option>
            @foreach ($kategoriList as $item)
                <option value="{{ $item->id }}" {{ $filterKategori == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_kategori }}
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

@if ($noBarangFound)
    <div class="text-center text-red-500 font-semibold mt-4 mb-6">
        Tidak ada data yang cocok dengan pencarian anda. Silakan cari data lain.
    </div>
@endif

<!-- Daftar Barang Berdasarkan Kategori -->
@foreach ($data as $kategori)
    @if($kategori->barangs->count() > 0)
    <div class="mb-10">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Barang dalam Kategori: {{ $kategori->nama_kategori }}</h2>
        <div class="overflow-x-auto rounded-lg border border-gray-300 shadow-sm">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-green-300 text-black">
                        <th class="py-3 px-4 font-bold text-center rounded-tl-lg">No</th>
                        <th class="py-3 px-4 font-bold text-center">Nama Barang</th>
                        <th class="py-3 px-4 font-bold text-center">Jumlah</th>
                        <th class="py-3 px-4 font-bold text-center rounded-tr-lg">Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori->barangs as $index => $barang)
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 text-center">{{ $barang->nama_barang }}</td>
                        <td class="py-3 px-4 text-center">{{ $barang->jumlah }}</td>
                        <td class="py-3 px-4 text-center">{{ $kategori->nama_kategori }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endforeach

<!-- Form Tambah Kategori -->
<div id="tambah-kategori" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
    <div class="bg-white w-1/2 p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500">
        <h2 class="text-xl font-bold mb-4">Tambah Kategori</h2>
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="w-full px-3 py-2 border rounded-lg" placeholder="Masukkan nama kategori" required />
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2" onclick="closeForm()">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg" onclick="console.log('Form disubmit')">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Form Edit Kategori -->
<div id="edit-kategori" class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 z-50 flex justify-center items-center opacity-0 pointer-events-none transition-opacity duration-500">
    <div class="bg-white w-1/2 p-5 rounded-lg shadow-lg transform -translate-y-full transition-transform duration-500">
        <h2 class="text-xl font-bold mb-4">Edit Kategori</h2>
        <form id="editForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="w-full px-3 py-2 border rounded-lg" id="editNamaKategori" placeholder="Masukkan nama kategori" required />
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg mr-2" onclick="closeEditForm()">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const tambahKategori = document.getElementById('tambah-kategori');
    const formContent = tambahKategori.querySelector('div');

    function openForm() {
        tambahKategori.classList.remove('pointer-events-none', 'opacity-0');
        tambahKategori.classList.add('opacity-100');
        formContent.classList.remove('-translate-y-full');
        formContent.classList.add('translate-y-0');
    }

    function closeForm() {
        formContent.classList.remove('translate-y-0');
        formContent.classList.add('-translate-y-full');
        tambahKategori.classList.remove('opacity-100');
        tambahKategori.classList.add('opacity-0');
        setTimeout(() => {
            tambahKategori.classList.add('pointer-events-none');
        }, 500);
    }

    const editKategori = document.getElementById('edit-kategori');
    const editFormContent = editKategori.querySelector('div');

    function openEditForm(nama_kategori, id) {
        document.getElementById('editNamaKategori').value = nama_kategori;
        const editForm = document.getElementById('editForm');
        editForm.action = `/kategori/${id}`;
        editKategori.classList.remove('pointer-events-none', 'opacity-0');
        editKategori.classList.add('opacity-100');
        editFormContent.classList.remove('-translate-y-full');
        editFormContent.classList.add('translate-y-0');
    }

    function closeEditForm() {
        editFormContent.classList.remove('translate-y-0');
        editFormContent.classList.add('-translate-y-full');
        editKategori.classList.remove('opacity-100');
        editKategori.classList.add('opacity-0');
        setTimeout(() => {
            editKategori.classList.add('pointer-events-none');
        }, 500);
    }
</script>
@endsection
