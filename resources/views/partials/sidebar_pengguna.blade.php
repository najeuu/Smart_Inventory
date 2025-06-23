<!--sidebar-->
<div class="flex bg-gray-100 font-poppins h-screen">
    <div class="bg-blue-300 w-64 hidden md:flex md:flex-col rounded-tr-3xl rounded-br-3xl custom-shadow z-30">
        <div class="flex items-center mb-8 space-x-2 mt-4 justify-center">
            <img src="{{ url('/image/logoterbaru.png') }}" alt="Logo" class="h-14 w-14 mr-2">
            <div class="text-left">
            <h2 class="text-lg font-bold text-black ">
                <p class="font-bold text-[20px] tracking-wide">InventoryKu</p>
            </h2>
            </div>
        </div>

        <nav class="flex-1 w-full font-bold space-y-2">
            <a href="{{ route('dashboard_pengguna') }}" id="dashboard" class="flex items-center px-4 py-1 text-black hover:bg-blue-400 rounded-r-full mr-4">
                <span class="material-icons mr-4">dashboard</span>
                Beranda
            </a>
            <a href="/data_barang" id="data_barang" class="flex items-center px-4 py-1 text-black hover:bg-blue-400 rounded-r-full mr-4">
                <span class="material-icons mr-4">inventory</span>
                Data Barang
            </a>
            <a href="/peminjaman" id="peminjaman" class="flex items-center px-4 py-1  text-black hover:bg-blue-400 rounded-r-full mr-4">
                <span class="material-icons mr-4">shopping_cart</span>
                Peminjaman
            </a>
            <a href="/riwayat" id="riwayat" class="flex items-center px-4 py-1 text-black hover:bg-blue-400 rounded-r-full mr-4">
                <span class="material-icons mr-4">history</span>
                Riwayat
            </a>
        </nav>

        <div class="w-full space-y-2 font-bold mb-6">
            <a href="/setting" id="setting" class="flex items-center px-4 py-1 text-black  hover:bg-blue-400 rounded-r-full mr-4">
                <span class="material-icons mr-4">settings</span>
                Pengaturan
            </a>
            <form action="{{ route('logout') }}" method="POST" class=" text-black hover:bg-blue-400 rounded-r-full mr-4">
                @csrf
                <button type="submit" id="logout"
                    class="flex items-center px-4 py-1 text-black hover:bg-blue-400 rounded-r-full mr-4">
                    <span class="material-icons mr-4">logout</span>
                    Keluar
                </button>
            </form>
        </div>
    </div>
</div>
