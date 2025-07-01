@extends('partials.head') {{-- Menggunakan layout/head utama --}}

@section('content')
<div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
    @include('partials.sidebar_pengguna')

    <!-- Konten Utama -->
    <main class="flex-1 p-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <div class="text-sm text-gray-700">
                {{ Auth::user()->username }}
                <i class="fas fa-user ml-2"></i>
            </div>
        </div>

        <!-- Kategori Alat -->
        <h2 class="text-xl font-semibold mb-4">KATEGORI ALAT</h2>
        <div class="grid grid-cols-2 gap-6">
            @foreach 
                <div class="bg-white shadow-md rounded-lg p-4 flex flex-col items-center">
                    <img src="{{ }}" alt="{{ }}" class="w-40 h-40 object-contain mb-2">
                    <p class="font-semibold text-center">{{ }}</p>
                </div>
            @endforeach
        </div>

    </main>
</div>
@endsection
