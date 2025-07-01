<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;


class KelolaPenggunaController extends Controller
{
    public function index()
    {
        $kelolapengguna = User::all(); // ambil semua user

        return view('kelolapengguna', compact('kelolapengguna'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,pengguna',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('kelolapengguna.index')->with('success', 'Role pengguna diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('kelolapengguna.index')->with('success', 'Data pengguna berhasil dihapus.');
    }
}
