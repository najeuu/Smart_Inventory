@extends('layout.dasboard')

@section('title', 'Dashboard')

@section('content')
<div class="flex items-center justify-center h-full">
    <div>
        <div class="mb-[40px] text-center">
            @php use Illuminate\Support\Str; @endphp
            <h1 class="text-3xl font-bold text-gray-800 mb-4"> Selamat Datang di InventoriKu
            </h1>
        </div>

        <div class="grid grid-cols-2 gap-[50px] justify-items-center">
            <!-- Barang Tersedia -->
            <div class="w-[350px] h-[150px] bg-blue-300 flex items-center pl-8 rounded-lg shadow-lg">
                <span class="material-symbols-outlined text-6xl mr-4">domain_verification</span>
                <div>
                    <p class="font-bold">Barang Tersedia</p>
                    <p>{{ $availableItems }}</p>
                    <a href="{{ route('data_barang') }}" class="text-sm text-gray-700 underline mt-2">Lihat Detail</a>
                </div>
            </div>

            <!-- Barang Hampir Habis -->
            <div class="w-[350px] h-[150px] bg-blue-300 flex items-center pl-8 rounded-lg shadow-lg">
                <span class="material-symbols-outlined text-6xl mr-4">problem</span>
                <div>
                    <p class="font-bold text-black">Barang Hampir Habis</p>
                    <p id="almostOutCount" class="text-lg font-semibold text-black"></p>
                    <p id="stockStatus" class="font-regular text-black"></p>
                    <a href="{{ route('data_barang') }}" class="text-sm text-gray-700 underline mt-2">Lihat Detail</a>
                </div>
            </div>

            <!-- Laporan Barang -->
            <div class="w-[350px] h-[150px] bg-blue-300 flex items-center pl-8 rounded-lg shadow-lg">
                <span class="material-symbols-outlined text-6xl mr-4">event_upcoming</span>
                <div>
                    <p class="font-bold">Laporan Barang</p>
                    <a href="{{ route('laporan') }}" class="text-sm text-gray-700 underline mt-2">Lihat Detail</a>
                </div>
            </div>

            <!-- Barang Dipinjam -->
            <div class="w-[350px] h-[150px] bg-blue-300 flex items-center pl-8 rounded-lg shadow-lg">
                <span class="material-symbols-outlined text-6xl mr-4">open_in_browser</span>
                <div>
                    <p class="font-bold">Barang Dipinjam</p>
                    <p>{{ $borrowedItems }}</p>
                    <a href="{{ route('peminjaman') }}" class="text-sm text-gray-700 underline mt-2">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
