@php
    $activeClass = 'bg-blue-500 text-white';
@endphp

<!--sidebar-->
<div class="flex bg-gray-100 font-poppins h-screen">
    <div class="bg-blue-300 w-64 hidden md:flex md:flex-col rounded-tr-3xl rounded-br-3xl custom-shadow z-30">
        <div class="flex items-center mb-8 space-x-2 mt-4 justify-center">
            <img src="{{ url('/image/logo.png') }}" alt="Logo" class="h-14 w-14 mr-2">
            <div class="text-left">
                <h2 class="text-lg font-bold text-black">
                    <p class="font-bold text-[20px] tracking-wide">InventoriKu</p>
                </h2>
            </div>
        </div>

        <nav class="flex-1 w-full font-bold space-y-2">
            <a href="{{ route('dashboard_pengguna') }}"
               class="flex items-center px-4 py-1 hover:bg-blue-400 rounded-r-full mr-4
                      {{ request()->routeIs('dashboard_pengguna') ? $activeClass : 'text-black' }}">
                <span class="material-icons mr-4">dashboard</span>
                Beranda
            </a>

            <a href="{{ url('/peminjaman') }}"
               class="flex items-center px-4 py-1 hover:bg-blue-400 rounded-r-full mr-4
                      {{ request()->is('peminjaman') ? $activeClass : 'text-black' }}">
                <span class="material-icons mr-4">shopping_cart</span>
                Peminjaman
            </a>

            <a href="{{ url('/pengembalian') }}"
               class="flex items-center px-4 py-1 hover:bg-blue-400 rounded-r-full mr-4
                      {{ request()->is('pengembalian') ? $activeClass : 'text-black' }}">
                <span class="material-icons mr-4">undo</span>
                Pengembalian
            </a>

            <a href="{{ url('/riwayat-pengguna') }}"
               class="flex items-center px-4 py-1 hover:bg-blue-400 rounded-r-full mr-4
                      {{ request()->is('riwayat-pengguna') ? $activeClass : 'text-black' }}">
                <span class="material-icons mr-4">history</span>
                Riwayat
            </a>
        </nav>

        <div class="w-full space-y-2 font-bold mb-6">
            <a href="{{ route('setting.pengguna') }}"
               class="flex items-center px-4 py-1 hover:bg-blue-400 rounded-r-full mr-4
                      {{ request()->routeIs('setting.pengguna') ? $activeClass : 'text-black' }}">
                <span class="material-icons mr-4">settings</span>
                Pengaturan
            </a>

            <form action="{{ route('logout') }}" method="POST" class="mr-4">
                @csrf
                <button type="submit"
                        class="w-full flex items-center px-4 py-1 hover:bg-blue-400 rounded-r-full
                               {{ request()->is('logout') ? $activeClass : 'text-black' }}">
                    <span class="material-icons mr-4">logout</span>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>
