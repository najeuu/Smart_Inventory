<head>
    @include('partials.head')
</head>
<body class="flex items-center justify-center min-h-screen bg-yellow-400">
    <div class="absolute inset-0">
        <img src="{{url('image/background.png')}}" alt="Background" class="object-cover w-full h-full opacity-40">
    </div>

    <!-- Form Login -->
    <div class="relative z-10 bg-white bg-opacity-80 rounded-lg shadow-lg w-80 p-6">
        <h1 class="text-2xl font-bold text-center mb-6">Masuk Akun</h1>
        <form action="/login" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Nama Pengguna</label>
                <input type="text" name="username" id="username" required
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-gray-100 border border-gray-300 rounded-lg focus:ring focus:ring-yellow-500">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <input type="password" name="password" id="password" required
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-gray-100 border border-gray-300 rounded-lg focus:ring focus:ring-yellow-500">
            </div>
            <div class="text-sm text-center">
                <span>Belum Mendaftar? <a href="{{}}" class="text-yellow-500 font-semibold">Daftar</a></span>
            </div>
            <button type="submit"
                class="w-36 mx-auto block px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-500 transition">
                Masuk
            </button>
        </form>
    </div>
</body>
</html>
