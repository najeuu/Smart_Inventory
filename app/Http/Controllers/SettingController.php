<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('setting', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Kata sandi lama salah']);
            }
        }

        $request->validate([
            'name' => 'nullable|string|max:255|unique:users,username,' . Auth::id(),
            'email' => 'nullable|email|unique:users,email,' . Auth::id(),
            'new_password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.unique' => 'Nama sudah digunakan',
            'email.unique' => 'Email sudah digunakan',
            'new_password.min' => 'Kata sandi baru harus minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi kata sandi tidak sesuai',
        ]);

        if ($request->filled('name')) {
            $user->username = $request->name;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Data berhasil diperbarui!');
    }

    public function settingPengguna()
    {
        $user = Auth::user();
        return view('setting_pengguna', compact('user'));
    }

    public function updatePengguna(Request $request)
    {
        $user = Auth::user();

        if ($request->filled('current_password') && !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi lama salah']);
        }

        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:users,nim,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->nama_mahasiswa = $request->nama_mahasiswa;
        $user->nim = $request->nim;
        $user->username = $request->username;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Data berhasil diperbarui!');
    }
}
