@extends('layout.databarang-pengguna')

@section('title', 'Data Barang')

@section('content')
    @push('scripts')
        <script src="{{ asset('js/reader.js') }}" type="module"></script>
        <script src="{{ asset('js/rfid-scanner.js') }}" type="module"></script>
    @endpush

    <div class="w-full px-8 py-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Kategori Alat</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($kategoris as $kategori)
                <a href="{{ route('pengguna.data_barang.kategori', $kategori->nama_kategori) }}" class="transition-transform transform hover:scale-105">
                    <div class="bg-white p-4 rounded shadow text-center hover:bg-blue-100">
                        <img src="{{ asset('image/' . $kategori->nama_kategori . '.png') }}" class="h-32 mx-auto object-contain" alt="{{ $kategori->nama_kategori }}">
                        <p class="mt-2 font-semibold text-gray-700">{{ $kategori->nama_kategori }}</p>
                    </div>
                </a>
            @empty
                <p class="text-gray-500 col-span-full">Tidak ada kategori yang tersedia.</p>
            @endforelse
        </div>
    </div>
@endsection
