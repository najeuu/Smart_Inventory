@extends('layout.dasboard')

@section('title', 'Dashboard')

@section('content')
<div class="w-screen flex items-center justify-center min-h-screen bg-gray-100 font-poppins">
    <div>
        <div class="mb-[40px]">
            <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-widest">HALO LABORAN</h1>
            <p class="mt-[-5px] tracking-wide">Selamat Datang di MANAJEMEN BARANG LABORAN</p>
        </div>

        <div class="grid grid-cols-2 gap-[70px]">
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
                    <!-- Menampilkan jumlah barang yang hampir habis -->
                    <p id="almostOutCount" class="text-lg font-semibold text-black"></p>

                    <!-- Menampilkan pesan "Stok Aman" jika tidak ada barang yang hampir habis -->
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

<!-- Notifikasi Overlay -->
<div id="notif-overlay" class="fixed inset-0 bg-red-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
        <h2 class="text-3xl font-bold text-red-600 mb-4 animate-bounce">PERHATIAN!</h2>
        <p id="notif-message" class="text-lg font-medium text-gray-800">Ada barang yang hampir habis! Segera cek stok.</p>
        
        <!-- Menampilkan daftar nama barang yang hampir habis di dalam notifikasi -->
        <div id="almostOutItemsList" class="mt-4 text-left text-black"></div>

        <button id="notif-close" class="mt-4 px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700">Tutup</button>
    </div>
</div>

<script>
    function checkAlmostOutItems() {
        fetch("{{ url('/dashboard/almost-out-items') }}")
            .then(response => response.json())
            .then(data => {
                const notifOverlay = document.getElementById('notif-overlay');
                const count = document.getElementById('almostOutCount');
                const notifMessage = document.getElementById('notif-message');
                const itemsList = document.getElementById('almostOutItemsList');
                const stockStatus = document.getElementById('stockStatus'); 

                // Jika mendeteksi barang yang hampir habis
                if (data.almostOutItems.length > 0) {
                    count.textContent = data.almostOutItems.length; // Menampilkan jumlah barang yang hampir habis
                    stockStatus.textContent = ''; 
                    
                    // Menampilkan daftar barang yang hampir habis hanya di dalam notifikasi
                    itemsList.innerHTML = '<ul>' + data.almostOutItems.map(item => `<li>${item}</li>`).join('') + '</ul>';

                    localStorage.setItem('almostOutItems', 'true');
                    notifOverlay.classList.remove('hidden');
                } else {
                    count.textContent = '';
                    itemsList.innerHTML = ''; 
                    stockStatus.textContent = 'Stok Aman'; 
                    notifOverlay.classList.add('hidden'); 
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    document.getElementById('notif-close').addEventListener('click', function () {
        document.getElementById('notif-overlay').classList.add('hidden');
        localStorage.removeItem('almostOutItems'); 
    });

    // Fungsi untuk waktu notif muncul tiap 5 detik
    setInterval(checkAlmostOutItems, 5000);
    checkAlmostOutItems();
</script>
@endsection
