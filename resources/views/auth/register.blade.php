<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.head')
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-yellow-400">
    <!-- Background -->
    <div class="absolute inset-0">
        <img src="{{ url('image/background.png') }}" alt="Background" class="object-cover w-full h-full opacity-40">
    </div>

    <!-- Form Register -->
    <div class="relative z-10 bg-white bg-opacity-80 rounded-lg shadow-lg w-11/12 max-w-sm p-6">
        <h1 class="text-2xl font-bold text-center mb-6">Daftar Akun</h1>
        <form action="/register" method="POST" class="space-y-4" onsubmit="return validateForm();">
            @csrf
            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Nama Pengguna</label>
                <input type="text" name="username" id="username" required value="{{ old('username') }}"
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-gray-100 border border-gray-300 rounded-lg focus:ring focus:ring-yellow-500 focus:outline-none">
                @error('username')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-gray-100 border border-gray-300 rounded-lg focus:ring focus:ring-yellow-500 focus:outline-none">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <input type="password" name="password" id="password" required
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-gray-100 border border-gray-300 rounded-lg focus:ring focus:ring-yellow-500 focus:outline-none">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Kata
                    Sandi</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="block w-full px-4 py-2 mt-1 text-gray-900 bg-gray-100 border border-gray-300 rounded-lg focus:ring focus:ring-yellow-500 focus:outline-none">
            </div>

            <!-- Login -->
            <div class="text-sm text-center">
                <span>Sudah Punya Akun?
                    <a href="{{ route('login') }}" class="text-yellow-500 font-semibold hover:underline">
                        Masuk
                    </a>
                </span>
            </div>

            <!-- Tombol Daftar -->
            <button type="submit"
                class="w-full px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-500 transition">
                Daftar
            </button>
        </form>
    </div>

    <!-- Script Validasi -->
    <script>
        function validateForm() {
            // Ambil input password dan konfirmasi password
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            // Cek jika konfirmasi kata sandi tidak sama dengan kata sandi
            if (password !== passwordConfirmation) {
                alert("Konfirmasi kata sandi tidak sesuai dengan kata sandi.");
                return false; // Mencegah form terkirim
            }
            return true; // Melanjutkan submit jika validasi berhasil
        }
    </script>
</body>

</html>
