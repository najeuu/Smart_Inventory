<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>
    <!-- Menambahkan CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Layout Utama -->
    <div class="flex">

        <!-- Sidebar -->
        <div class="w-64 h-screen bg-orange-400 p-5 text-white">
            <h2 class="text-2xl font-bold mb-6">Manajemen Barang Laboran</h2>
            <ul class="space-y-6">
                <li class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a1 1 0 001.22 0L21 8m-18 0l7.89 5.26a1 1 0 001.22 0L21 8m-9 6v6m4-6v6" />
                    </svg>
                    <a href="/dashboard" class="hover:text-gray-200">Dashboard</a>
                </li>
                <li class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16m-7 4h7" />
                    </svg>
                    <a href="/data-barang" class="hover:text-gray-200">Data Barang</a>
                </li>
                <li class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16v8m0-8V4m0 4h5m-5 0h5m0 4H7m0 0V4" />
                    </svg>
                    <a href="/peminjaman" class="hover:text-gray-200">Peminjaman</a>
                </li>
                <li class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 9v6m-8-6v6" />
                    </svg>
                    <a href="/pengembalian" class="hover:text-gray-200">Pengembalian</a>
                </li>
                <li class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                    </svg>
                    <a href="/riwayat" class="font-semibold text-white">Riwayat</a>
                </li>
                <li class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1v-2z" />
                    </svg>
                    <a href="/laporan" class="hover:text-gray-200">Laporan</a>
                </li>
                <li class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <a href="/setting" class="hover:text-gray-200">Setting</a>
                </li>
                <li class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <a href="/logout" class="hover:text-gray-200">Logout</a>
                </li>
            </ul>
        </div>

        <!-- Konten -->
        <div class="w-full p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">HALO LABORAN</h1>
            <p class="text-gray-600 mb-8">Selamat Datang di Halaman Riwayat Peminjaman</p>

            <table class="w-full bg-white border border-gray-200 rounded-md overflow-hidden shadow">
                <thead class="bg #F9C78D text-black">
                    <tr>
                        <th class="py-3 px-4 text-left border-b">No</th>
                        <th class="py-3 px-4 text-left border-b">Nama Mahasiswa</th>
                        <th class="py-3 px-4 text-left border-b">NIM</th>
                        <th class="py-3 px-4 text-left border-b">Tanggal Peminjaman</th>
                        <th class="py-3 px-4 text-left border-b">Tanggal Pengembalian</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($riwayat as $index => $data)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">{{ $data->nama_mahasiswa }}</td>
                            <td class="py-3 px-4">{{ $data->nim }}</td>
                            <td class="py-3 px-4">{{ $data->tanggal_peminjaman }}</td>
                            <td class="py-3 px-4">{{ $data->tanggal_pengembalian }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>