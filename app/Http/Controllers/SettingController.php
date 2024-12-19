<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingController extends Controller
{
    // Menampilkan halaman setting
    public function index()
    {
        $user = Auth::user();
        return view('setting', ['user' => $user]);
    }

    // Memproses update data
    public function update(Request $request)
    {
        $user = Auth::user();

        // Jika input current_password diisi, maka lakukan pengecekan terlebih dahulu
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi lama salah']);
            }
        }

        // Validasi input (nama, email, password)
        $request->validate([
            'name' => 'nullable|string|max:255|unique:users,username,' . Auth::id(), // Tambah validasi unique
            'email' => 'nullable|email|unique:users,email,' . Auth::id(),
            'new_password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.unique' => 'Nama sudah digunakan',
            'email.unique' => 'Email sudah digunakan',
            'new_password.min' => 'Kata sandi baru harus minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi kata sandi tidak sesuai',
        ]);

        // Update nama jika ada input baru
        if ($request->filled('name')) {
            $user->username = $request->name;
        }

        // Update email jika ada input baru
        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        // Update password jika input valid
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        // Simpan perubahan ke database
        $user->save();

        return back()->with('success', 'Data berhasil diperbarui!');
    }
}
