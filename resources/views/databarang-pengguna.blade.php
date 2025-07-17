@extends('layout.databarang-pengguna')

@section('title', 'Data Barang')

@section('content')
    @push('scripts')
        <script src="{{ asset('js/reader.js') }}" type="module"></script>
        <script src="{{ asset('js/rfid-scanner.js') }}" type="module"></script>
    @endpush

    <div class="w-full px-8 py-6">

        {{-- Judul kategori --}}
        <h1 class="text-2xl font-bold mb-4">
            @isset($kategori)
                Kategori: {{ $kategori->nama_kategori }}
            @else
                Silakan pilih kategori untuk melihat daftar barang
            @endisset
        </h1>

        {{-- Daftar Barang --}}
        @if(isset($barangs) && $barangs->count() > 0)
            @foreach ($barangs as $barang)
                <div class="bg-white p-4 rounded-xl shadow mb-4">
                    <h2 class="text-lg font-bold">{{ $barang->nama_barang }}</h2>
                    <p><strong>Stok:</strong> {{ $barang->jumlah }} pcs</p>
                    <p><strong>Deskripsi:</strong><br> {!! nl2br(e($barang->deskripsi)) !!}</p>
                </div>
            @endforeach
        @elseif(isset($kategori))
            <p class="text-gray-600 italic">Belum ada barang dalam kategori ini.</p>
        @else
            <p class="text-gray-600 italic">Silakan pilih kategori terlebih dahulu dari halaman dashboard.</p>
        @endif

    </div>
@endsection
