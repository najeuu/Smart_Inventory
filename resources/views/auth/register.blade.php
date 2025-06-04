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

<body class="flex items-center justify-end min-h-screen pr-20">
    <!-- Background -->
    <div class="absolute inset-0">
        <img src="{{ url('image/background_login.png') }}" alt="Background" class="object-cover w-full h-full">
    </div>

    <!-- Form Register -->
    <div class="relative z-10 bg-white bg-opacity-80 rounded-lg shadow-lg w-11/12 max-w-sm p-6">
        <h1 class="text-2xl font-bold text-center mb-6">Daftar Akun</h1>
        <form action="/register" method="POST" class="space-y-4" onsubmit="return validateForm();">
            @csrf
            <!-- Email Field -->
            <div class="mb-5">
                <label for="email" class="block text-base font-medium text-gray-600 mb-3">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        class="block w-full pl-12 pr-4 py-4 text-base text-gray-900 bg-gray-100 border-0 rounded-xl focus:ring-0 focus:outline-none transition-all duration-200">
                </div>
                @error('email')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Username Field -->
            <div class="mb-5">
                <label for="username" class="block text-base font-medium text-gray-600 mb-3">Nama Pengguna</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input type="text" name="username" id="username" required value="{{ old('username') }}"
                        class="block w-full pl-12 pr-4 py-4 text-base text-gray-900 bg-gray-100 border-0 rounded-xl focus:ring-0 focus:outline-none transition-all duration-200">
                </div>
                @error('username')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="mb-5">
                <label for="password" class="block text-base font-medium text-gray-600 mb-3">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input type="password" name="password" id="password" required
                        class="block w-full pl-12 pr-14 py-4 text-base text-gray-900 bg-gray-100 border-0 rounded-xl focus:ring-0 focus:outline-none transition-all duration-200">
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer">
                        <!-- Eye Icon (Show) -->
                        <svg id="eyeShow" class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <!-- Eye Off Icon (Hide) -->
                        <svg id="eyeHide" class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464M14.12 14.12l1.415 1.415M14.12 14.12L9.88 9.88m4.24 4.24L18.314 18.314M9.88 9.88L5.636 5.636m0 0L3.464 3.464m2.172 2.172L8.464 8.464m7.071 7.071l2.172 2.172"></path>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-6">
                <label for="password_confirmation" class="block text-base font-medium text-gray-600 mb-3">Konfirmasi Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="block w-full pl-12 pr-14 py-4 text-base text-gray-900 bg-gray-100 border-0 rounded-xl focus:ring-0 focus:outline-none transition-all duration-200">
                    <button type="button" id="togglePasswordConfirm" class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer">
                        <!-- Eye Icon (Show) -->
                        <svg id="eyeShowConfirm" class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <!-- Eye Off Icon (Hide) -->
                        <svg id="eyeHideConfirm" class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464M14.12 14.12l1.415 1.415M14.12 14.12L9.88 9.88m4.24 4.24L18.314 18.314M9.88 9.88L5.636 5.636m0 0L3.464 3.464m2.172 2.172L8.464 8.464m7.071 7.071l2.172 2.172"></path>
                        </svg>
                    </button>
                </div>

            <!-- Login -->
            <div class="text-sm text-center mt-5">
                <span>Sudah Punya Akun?
                    <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline ml-1">
                        Masuk
                    </a>
                </span>
            </div>

             <!-- Login Button -->
            <button type="submit"
                class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200 mt-4">
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
    <!-- JavaScript untuk toggle password visibility -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle untuk Password
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeShow = document.getElementById('eyeShow');
            const eyeHide = document.getElementById('eyeHide');

            togglePassword.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeShow.classList.add('hidden');
                    eyeHide.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeShow.classList.remove('hidden');
                    eyeHide.classList.add('hidden');
                }
            });

            // Toggle untuk Confirm Password
            const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const eyeShowConfirm = document.getElementById('eyeShowConfirm');
            const eyeHideConfirm = document.getElementById('eyeHideConfirm');

            togglePasswordConfirm.addEventListener('click', function() {
                if (passwordConfirmInput.type === 'password') {
                    passwordConfirmInput.type = 'text';
                    eyeShowConfirm.classList.add('hidden');
                    eyeHideConfirm.classList.remove('hidden');
                } else {
                    passwordConfirmInput.type = 'password';
                    eyeShowConfirm.classList.remove('hidden');
                    eyeHideConfirm.classList.add('hidden');
                }
            });
        });
        </script>
</body>

</html>
