@extends('layout.dasboard')

@section('title', 'Dasboard')

@section('content')

<div class="w-screen flex items-center justify-center min-h-screen bg-gray-100 font-poppins ">
    <div>
        <div class="mb-[40px]">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-widest">HALO LABORAN</h1>
            
            <p class="mt-[-5px] tracking-wide">Selamat Datang di MANAJEMEN BARANG LABORAN</p>
        </div>

        <div class="grid grid-cols-2 gap-[70px]">
            <div class="w-[350px] h-[150px] bg-orange-300 flex items-center pl-8 rounded-lg shadow-lg custom-shadow">
                <span class="material-symbols-outlined text-6xl mr-4">domain_verification</span><div>
                    <p class="font-bold">Barang Tersedia</p>
                    <p>120 Barang</p>
                </div>
            </div>

            <div class="w-[350px] h-[150px] bg-orange-300 flex items-center pl-8 rounded-lg shadow-lg custom-shadow">
                <span class="material-symbols-outlined text-6xl mr-4">problem</span>
                <div>
                    <p class="font-bold">Barang Hampir Habis</p>
                    <p>120 Barang</p>
                </div>
            </div>

            <div class="w-[350px] h-[150px] bg-orange-300 flex items-center pl-8 rounded-lg shadow-lg custom-shadow">
                <span class="material-symbols-outlined text-6xl mr-4">event_upcoming</span>
                <div>
                    <p class="font-bold">Laporan Barang</p>
                    <p>120 Barang</p>
                </div>
            </div>

            <div class="w-[350px] h-[150px] bg-orange-300 flex items-center pl-8 rounded-lg shadow-lg custom-shadow">
                <span class="material-symbols-outlined text-6xl mr-4">open_in_browser</span>
                <div>
                    <p class="font-bold">Barang Dipinjam</p>
                    <p>120 Barang</p>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
