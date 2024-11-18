<div class="flex items-center h-screen bg-gray-100 font-poppins">
    <div class="w-[200px] h-[550px] bg-orange-300 text-black flex flex-col py-7 rounded-r-2xl custom-shadow z-30">
        <div class="flex mb-7 bg-orange-300 ml-4">
            <img src="{{ url('/image/logo.png') }}" alt="Logo" class="h-12 mr-3" />
            <div class="text-left">
                <p class="font-bold text-[8pt]">MANAJEMEN</p>
                <p class="font-bold text-[8pt]">BARANG</p>
                <p class="font-bold text-[8pt]">LABORAN</p>
            </div>
        </div>

        <nav class="flex-1 w-full text-[8pt] font-bold space-y-2">
            <a href="#" class="flex items-center px-4 py-1 text-black hover:bg-orange-400 rounded-r-full mr-4">
                <span class="material-icons mr-4">dashboard</span>
                Dashboard
            </a>
            <a href="#" class="flex items-center px-4 py-1 text-black hover:bg-orange-400 rounded-r-full mr-4">
                <span class="material-icons mr-4">inventory</span>
                Data Barang
            </a>
            <a href="#" class="flex items-center px-4 py-1 text-black hover:bg-orange-400 rounded-r-full mr-4">
                <span class="material-icons mr-4">shopping_cart</span>
                Peminjaman
            </a>
            <a href="#" class="flex items-center px-4 py-1 text-black hover:bg-orange-400 rounded-r-full mr-4">
                <span class="material-icons mr-4">undo</span>
                Pengembalian
            </a>
            <a href="#" class="flex items-center px-4 py-1 text-black hover:bg-orange-400 rounded-r-full mr-4">
                <span class="material-icons mr-4">history</span>
                Riwayat
            </a>
            <a href="#" class="flex items-center px-4 py-1 text-black hover:bg-orange-400 rounded-r-full mr-4">
                <span class="material-icons mr-4">description</span>
                Laporan
            </a>
        </nav>

        <div class="w-full space-y-2 text-[8pt] font-bold">
            <a href="#" class="flex items-center px-4 py-1 text-black bg-white rounded-r-full mr-4">
                <span class="material-icons mr-4">settings</span>
                Setting
            </a>
            <a href="#" class="flex items-center px-4 py-1 text-black hover:bg-orange-400 rounded-r-full mr-4">
                <span class="material-icons mr-4">logout</span>
                Logout
            </a>
        </div>
    </div>
</div>
