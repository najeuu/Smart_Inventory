@extends('layout.dasboard')

@section('title', 'Dashboard')

@section('content')
<div class="flex items-center justify-center h-full flex-col w-full">
    <div class="w-full max-w-6xl">
        <div class="mb-[40px] mt-[30px] text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang di InventoriKu</h1>
        </div>

        {{-- NOTIFIKASI POPUP --}}
        @if ($almostOutItems->count() > 0)
            <div id="alertPopup" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                    <h2 class="text-xl font-bold text-red-600 mb-4">⚠ Barang Hampir Habis</h2>
                    <p class="text-gray-700">Beberapa barang memiliki stok rendah:</p>
                    <ul class="list-disc list-inside text-sm text-gray-800 mt-2 mb-4 max-h-[150px] overflow-y-auto">
                        @foreach ($almostOutItems as $item)
                            <li>{{ $item->nama_barang }} (sisa {{ $item->jumlah }})</li>
                        @endforeach
                    </ul>
                    <button onclick="document.getElementById('alertPopup').style.display='none'" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Oke
                    </button>
                </div>
            </div>
        @endif

        <!-- Statistik Peminjaman -->
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-4xl mx-auto">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">📈 Statistik Peminjaman 7 Hari Terakhir</h2>
            <div class="relative h-64"> <!-- Batasi tinggi di sini -->
                <canvas id="peminjamanChart" class="w-full h-full"></canvas>
            </div>
        </div>


        {{-- Kartu Statistik --}}
        <div class="grid grid-cols-2 gap-[50px] justify-items-center mt-12">
            <!-- Barang Tersedia -->
            <div class="w-[350px] h-[150px] bg-blue-300 rounded-lg shadow-lg px-6 flex items-center">
                <span class="material-symbols-outlined text-5xl text-black mr-4">domain_verification</span>
                <div class="text-black">
                    <p class="font-bold">Barang Tersedia</p>
                    <p>{{ $availableItems }}</p>
                    <a href="{{ route('data_barang') }}" class="text-sm text-gray-700 underline mt-1 inline-block">Lihat Detail</a>
                </div>
            </div>

            <!-- Barang Hampir Habis -->
            <div class="w-[350px] h-[150px] bg-blue-300 rounded-lg shadow-lg px-6 flex items-center">
                <span class="material-symbols-outlined text-5xl text-black mr-4">warning</span>
                <div class="text-black">
                    <p class="font-bold">Barang Hampir Habis</p>
                    @if ($almostOutItems->count() > 0)
                        <ul class="text-sm list-disc list-inside max-h-[60px] overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200">
                            @foreach ($almostOutItems as $item)
                                <li>{{ $item->nama_barang }} ({{ $item->jumlah }})</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm">Tidak ada</p>
                    @endif
                    <a href="{{ route('data_barang') }}" class="text-sm text-gray-700 underline mt-1 inline-block">Lihat Detail</a>
                </div>
            </div>

            <!-- Laporan Barang -->
            <div class="w-[350px] h-[150px] bg-blue-300 rounded-lg shadow-lg px-6 flex items-center">
                <span class="material-symbols-outlined text-5xl text-black mr-4">event_upcoming</span>
                <div class="text-black">
                    <p class="font-bold">Laporan Barang</p>
                    <a href="{{ route('laporan') }}" class="text-sm text-gray-700 underline mt-1 inline-block">Lihat Detail</a>
                </div>
            </div>

            <!-- Barang Dipinjam -->
            <div class="w-[350px] h-[150px] bg-blue-300 rounded-lg shadow-lg px-6 flex items-center">
                <span class="material-symbols-outlined text-5xl text-black mr-4">open_in_browser</span>
                <div class="text-black">
                    <p class="font-bold">Barang Dipinjam</p>
                    <p>{{ $borrowedItems }}</p>
                    <a href="{{ url('/riwayat') }}" class="text-sm text-gray-700 underline mt-1 inline-block">Lihat Detail</a>
                </div>
            </div>
        </div>
</div>
@endsection

{{-- Script untuk Chart.js --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('peminjamanChart');
        if (!ctx) return;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: {!! json_encode($data) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    });
</script>
@endpush
