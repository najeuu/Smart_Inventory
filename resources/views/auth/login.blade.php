<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.head')
    <style>
        body {
            overflow: hidden;
        }
    </style>
    <script>
        function showPopup(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>

<body class="flex items-center justify-center min-h-screen bg-yellow-400">
    <!-- Background -->
    <div class="absolute inset-0">
        <img src="{{ url('image/background.png') }}" alt="Background" class="object-cover w-full h-full opacity-40">
    </div>

    <!-- Login -->
    <div class="relative z-10 bg-white bg-opacity-80 rounded-lg shadow-lg w-11/12 max-w-sm p-6">
        <h1 class="text-2xl font-bold text-center mb-6">Masuk Akun</h1>
        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <!-- Notifikasi Error -->
            @if (session('error'))
                <script>
                    alert("{{ session('error') }}");
                </script>
            @endif

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Nama Pengguna</label>
                <input type="text" name="username" id="username" required value="{{ old('username') }}"
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-gray-100 border border-gray-300 rounded-lg focus:ring focus:ring-yellow-500 focus:outline-none">
                @error('username')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="mt-2 block text-sm font-medium text-gray-700">Kata Sandi</label>
                <input type="password" name="password" id="password" required
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-gray-100 border border-gray-300 rounded-lg focus:ring focus:ring-yellow-500 focus:outline-none">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Registration -->
            <div class="text-sm text-center mt-2">
                <span>Belum Mendaftar?
                    <a href="{{ route('register') }}" class="text-yellow-500 font-semibold hover:underline">
                        Daftar
                    </a>
                </span>
            </div>

            <!-- Tombol Login -->
            <button type="submit"
                class="mt-2 w-full px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-500 transition">
                Masuk
            </button>
        </form>
    </div>

    <!-- JavaScript untuk menampilkan pop-up -->
    @if (session('success'))
        <script>
            showPopup("{{ session('success') }}");
        </script>
    @endif
</body>

</html>
