@extends('layout.setting')

@section('content')
    <!-- main content -->
    <div class="w-full py-7 flex items-center justify-center min-screen bg-gray-100 font-poppins rounded relative">
        <div class="w-[400px] h-[530px] bg-orange-300 rounded-xl custom-shadow flex justify-center items-center">
            <div class="flex flex-col items-center w-[300]">
                <div class="bg-white w-full h-[300px] mb-8 p-4 rounded-3xl bg-opacity-80 shadow-md ">
                    <span class="material-symbols-outlined text-[140px] flex justify-center mb-16">account_circle</span>
                    <div class="flex justify-center">
                        <div class="font-semibold grid grid-cols-[auto,1fr] gap-2 mb-12">
                            <p>NAMA</p>
                            <p>: {{ $user->username }}</p>
                            <p>EMAIL</p>
                            <p>: {{ $user->email }}</p>
                        </div>
                    </div>
                </div>
                <!-- Tombol untuk menampilkan form -->
                <a href="javascript:void(0)" onclick="openForm()"
                    class="flex justify-center items-center bg-orange-500 hover:bg-orange-600 hover:text-gray-100 hover:shadow-sm w-[230px] h-[40px] font-bold rounded-full shadow-md">
                    UBAH DATA
                </a>
            </div>
        </div>

        <!-- Form Edit Nama & Password -->
        <div id="change-data-form"
            class="absolute top-0 left-0 w-full h-screen bg-white bg-opacity-10 backdrop-blur-md flex flex-col justify-center items-center transition-transform transform -translate-y-full z-10">
            <div class="bg-white w-full max-w-lg p-9 rounded-lg shadow-lg relative">
                <!-- Tombol Tutup -->
                <button onclick="closeForm()" class="absolute top-4 left-4 text-red-500 hover:text-red-700">
                    <span class="material-icons">close</span>
                </button>
                <h2 class="text-center font-bold mb-6 text-[25pt]">UBAH DATA</h2>

                <!-- Form -->
                <form action="{{ route('setting.update') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Input Nama -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium mb-2">Nama</label>
                        <input type="text" id="name" name="name" value="{{ $user->username }}"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-orange-300">
                    </div>

                    <!-- Input Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium mb-2">Email</label>
                        <input type="text" id="email" name="email" value="{{ $user->email }}"
                            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-orange-300">
                    </div>

                    <!-- Form Ganti Kata Sandi -->
                    <div id="change-password-form" class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium mb-2">Kata Sandi Lama</label>
                            <input type="password" id="current_password" name="current_password"
                                class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium mb-2">Kata Sandi Baru</label>
                            <input type="password" id="new_password" name="new_password"
                                class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium mb-2">Konfirmasi Kata
                                Sandi</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="w-full px-3 py-2 border rounded-lg">
                        </div>
                    </div>

                    <!-- Tombol Simpan -->
                    <button type="submit"
                        class="w-full py-2 bg-orange-500 text-white rounded-lg font-bold hover:bg-orange-600">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                alert("{{ $error }}");
            </script>
        @endforeach
    @endif

    <!-- JavaScript -->
    <script>
        const changeDataForm = document.getElementById('change-data-form');

        function openForm() {
            changeDataForm.classList.remove('-translate-y-full');
            changeDataForm.classList.add('translate-y-0');
        }

        function closeForm() {
            changeDataForm.classList.remove('translate-y-0');
            changeDataForm.classList.add('-translate-y-full');
        }
    </script>
@endsection
