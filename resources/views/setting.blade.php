@extends('layout.setting')

@section('content')

    <!-- main conten -->
    <div class="w-full py-8 flex items-center justify-center min-screen bg-gray-100 font-poppins rounded relative">
        <div class="w-[400px] h-[530px] bg-orange-300 rounded-xl custom-shadow flex justify-center items-center">
            <div class="flex flex-col items-center w-[300]">
                <div class="bg-white w-full h-[300px] mb-8 p-4 rounded-3xl bg-opacity-80 shadow-md ">
                    <span class="material-symbols-outlined text-[140px] flex justify-center mb-16">account_circle</span>
                    <div class="flex justify-center">
                        <div class="font-semibold grid grid-cols-[auto,1fr] gap-2 mb-12">
                            <p>NAMA</p>
                            <p>: Contoh123</p>
                            <p>EMAIL</p>
                            <p>: contoh@gmail.com</p>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0)" onclick="openForm()" class="flex justify-center items-center bg-orange-500 hover:bg-orange-600 hover:text-gray-100 hover:shadow-sm w-[230px] h-[40px] font-bold rounded-full shadow-md">
                    UBAH KATA SANDI
                </a>
            </div>
        </div>

        <!-- ganti pasword -->
        <div id="change-password-form" class="absolute top-0 left-0 w-full h-screen bg-white bg-opacity-10 backdrop-blur-md flex flex-col justify-center items-center transition-transform transform -translate-y-full z-10">
            <div class="bg-white w-full max-w-lg p-9 rounded-lg shadow-lg relative">
                <button onclick="closeForm()" class="absolute top-4 left-4 text-red-500 hover:text-red-700">
                    <span class="material-icons">close</span>
                </button>
                <h2 class="text- font-bold m-6 mb-12 text-center text-[25pt]">UBAH KATA SANDI</h2>
                <form class="space-y-4">
                    <div class="mb-4">
                        <label for="current-password" class="block text-sm font-medium mb-2">Kata Sandi Lama</label>
                        <input type="password" id="current-password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-orange-300">
                    </div>
                    <div class="mb-4">
                        <label for="new-password" class="block text-sm font-medium mb-2">Kata Sandi Baru</label>
                        <input type="password" id="new-password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-orange-300">
                    </div>
                    <div class="mb-4">
                        <label for="confirm-password" class="block text-sm font-medium mb-2">Konfirmasi Kata Sandi</label>
                        <input type="password" id="confirm-password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-orange-300">
                    </div>
                    <button type="submit" class="w-full py-2 bg-orange-500 text-white rounded-lg font-bold hover:bg-orange-600">Simpan</button>
                </form>
            </div>
        </div>
    </div>

<!-- js -->
<script>
    const changePasswordForm = document.getElementById('change-password-form');

    function openForm() {
        changePasswordForm.classList.remove('-translate-y-full');
        changePasswordForm.classList.add('translate-y-0');
    }

    function closeForm() {
        changePasswordForm.classList.remove('translate-y-0');
        changePasswordForm.classList.add('-translate-y-full');
    }
</script>

@endsection


