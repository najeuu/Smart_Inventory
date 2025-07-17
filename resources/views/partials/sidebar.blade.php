@php
    $activeClass = 'bg-blue-500 text-white';
@endphp

<!-- Sidebar -->
<div class="bg-blue-300 w-64 h-screen flex flex-col justify-between custom-shadow z-30">
    <div>
        <div class="flex items-center justify-center mt-6 mb-4">
            <img src="{{ url('/image/logo.png') }}" alt="Logo" class="h-16 w-16">
            <p class="font-bold text-lg ml-2">InventoriKu</p>
        </div>

        <nav class="space-y-2 font-bold px-4">
            <a href="{{ route('dasboard') }}"
               class="flex items-center py-2 rounded-lg px-3 hover:bg-blue-400 {{ request()->routeIs('dasboard') ? $activeClass : '' }}">
                <span class="material-icons mr-3">dashboard</span> Dashboard
            </a>

            <a href="{{ route('data_barang') }}"
               class="flex items-center py-2 rounded-lg px-3 hover:bg-blue-400 {{ request()->routeIs('data_barang') ? $activeClass : '' }}">
                <span class="material-icons mr-3">inventory</span> Data Barang
            </a>

            <a href="/lokasi"
               class="flex items-center py-2 rounded-lg px-3 hover:bg-blue-400 {{ request()->is('lokasi') ? $activeClass : '' }}">
                <span class="material-icons mr-3">location_on</span> Lokasi
            </a>

            <a href="/kategori"
               class="flex items-center py-2 rounded-lg px-3 hover:bg-blue-400 {{ request()->is('kategori') ? $activeClass : '' }}">
                <span class="material-icons mr-3">category</span> Kategori
            </a>

            <a href="/riwayat"
               class="flex items-center py-2 rounded-lg px-3 hover:bg-blue-400 {{ request()->is('riwayat*') ? $activeClass : '' }}">
                <span class="material-icons mr-3">history</span> Riwayat
            </a>

            <a href="/kelolapengguna"
               class="flex items-center py-2 rounded-lg px-3 hover:bg-blue-400 {{ request()->is('kelolapengguna') ? $activeClass : '' }}">
                <span class="material-icons mr-3">group</span> Kelola Pengguna
            </a>

            <a href="/laporan"
               class="flex items-center py-2 rounded-lg px-3 hover:bg-blue-400 {{ request()->is('laporan') ? $activeClass : '' }}">
                <span class="material-icons mr-3">description</span> Laporan
            </a>
        </nav>
    </div>

    <div class="space-y-2 font-bold px-4 mb-6">
        <a href="/setting"
        class="flex items-center py-2 rounded-lg px-3 hover:bg-blue-400 {{ request()->is('setting') ? $activeClass : '' }}">
            <span class="material-icons mr-3">settings</span> Pengaturan
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center py-2 rounded-lg px-3 hover:bg-blue-400">
                <span class="material-icons mr-3">logout</span> Keluar
            </button>
        </form>
    </div>
</div>
