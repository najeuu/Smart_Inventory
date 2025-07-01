@extends('layout.kelolapengguna')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="bg-gray-100 font-poppins leading-normal tracking-normal">
    <div class="w-full p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 tracking-widest">HALO LABORAN</h1>
        <p class="text-gray-600 mb-8 tracking-wide">Selamat Datang di Halaman Kelola Pengguna</p>

        <div class="overflow-hidden rounded-lg border border-gray-300 shadow-sm mb-8">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-blue-300 text-black">
                        <th class="py-3 px-4 font-bold text-center rounded-tl-lg">No</th>
                        <th class="py-3 px-4 font-bold text-left">Nama Pengguna</th>
                        <th class="py-3 px-4 font-bold text-left">Email</th>
                        <th class="py-3 px-4 font-bold text-center">Role</th>
                        <th class="py-3 px-4 font-bold text-center rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kelolapengguna as $index => $user)
                    <tr class="bg-white border-b hover:bg-gray-100">
                        <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 text-left">{{ $user->username }}</td>
                        <td class="py-3 px-4 text-left">{{ $user->email }}</td>
                        <td class="py-3 px-4 text-center capitalize">{{ $user->role }}</td>
                        <td class="py-3 px-4 text-center">
                            <button
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded"
                                onclick="openModal({{ $user->id }}, '{{ e($user->username) }}', '{{ e($user->email) }}', '{{ e($user->role) }}')">
                                Edit
                            </button>
                            <form action="{{ route('kelolapengguna.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-black">Form Edit Role Pengguna</h2>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-black mb-1">Nama Pengguna</label>
                <input id="editUsername" type="text" class="w-full px-4 py-2 border rounded-full" disabled>
            </div>

            <div class="mb-4">
                <label class="block text-black mb-1">Email</label>
                <input id="editEmail" type="text" class="w-full px-4 py-2 border rounded-full" disabled>
            </div>

            <div class="mb-6">
                <label class="block text-black mb-1">Role Saat Ini</label>
                <select id="editRole" name="role" class="w-full px-4 py-2 border rounded-full appearance-none">
                    <option selected hidden id="currentRoleOption"></option>
                    <option value="pengguna">Pengguna</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="bg-red-500 hover:bg-red-600 text-white font-semibold px-6 py-2 rounded-full">Batal</button>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded-full">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id, username, email, role) {
        document.getElementById('editModal').classList.remove('hidden');

        document.getElementById('editUsername').value = username;
        document.getElementById('editEmail').value = email;

        // Set current role sebagai opsi pertama
        const roleSelect = document.getElementById('editRole');
        const currentRoleOption = document.getElementById('currentRoleOption');
        currentRoleOption.textContent = role === 'admin' ? 'Admin (Saat Ini)' : 'Pengguna (Saat Ini)';
        currentRoleOption.value = role;

        roleSelect.value = role;

        // Set action URL ke form
        document.getElementById('editForm').action = `/kelola-pengguna/${id}`;
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
@endsection
