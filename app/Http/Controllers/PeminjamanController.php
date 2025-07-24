<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $data = Peminjaman::with(['user', 'barang'])
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $dataBarang = Barang::all();

        return view('peminjaman', compact('data', 'dataBarang', 'user'));
    }

    public function search(Request $request)
    {
        $nim = $request->input('nim');
        $peminjam = Peminjaman::whereHas('user', function ($query) use ($nim) {
            $query->where('nim', $nim);
        })->first();

        if (!$peminjam) {
            return response()->json(['error' => 'Data peminjam tidak ditemukan'], 404);
        }

        $barang = $peminjam->barang;
        return response()->json([
            'peminjam' => $peminjam,
            'barang' => $barang
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'jenis_barang' => 'required|array',
            'jenis_barang.*' => 'required|string|max:255',
            'total_barang' => 'required|array',
            'total_barang.*' => 'required|integer|min:1',
            'tanggal_peminjaman' => 'required|date',
            'kode_rfid' => 'required|array',
            'kode_rfid.*' => 'required|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $userId = Auth::id();

                foreach ($request->kode_rfid as $index => $kode_rfid_item) {
                    $total = $request->total_barang[$index];
                    $nama_barang_from_form = $request->jenis_barang[$index];

                    $barang = Barang::where('kode_rfid', $kode_rfid_item)->first();

                    if (!$barang) {
                        throw new \Exception("Barang dengan kode RFID '{$kode_rfid_item}' tidak ditemukan.");
                    }

                    if ($barang->nama_barang !== $nama_barang_from_form) {
                        throw new \Exception("Nama barang tidak sesuai dengan database untuk kode RFID '{$kode_rfid_item}'.");
                    }

                    if ($barang->jumlah < $total) {
                        throw new \Exception("Stok tidak cukup untuk barang: '{$barang->nama_barang}'. Tersedia: {$barang->jumlah}, Diminta: {$total}.");
                    }

                    Peminjaman::create([
                        'user_id' => $userId,
                        'kode_rfid' => $kode_rfid_item,
                        'barang_id' => $barang->id,
                        'total_barang' => $total,
                        'tanggal_peminjaman' => $request->tanggal_peminjaman,
                    ]);

                    $barang->reduceQuantity($total);
                }
            });

            return redirect()->route('peminjaman')->with('success', 'Peminjaman berhasil diajukan.');
        } catch (\Exception $e) {
            Log::error('Peminjaman failed: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('peminjaman')->with('error', 'Terjadi kesalahan saat peminjaman: ' . $e->getMessage());
        }
    }

    public function riwayatPengguna()
    {
        $riwayat = Peminjaman::with(['barang', 'pengembalians'])
            ->where('user_id', auth()->id())
            ->paginate(10);

        return view('riwayat-pengguna', compact('riwayat'));
    }

    public function searchByRfid(Request $request)
    {
        $request->validate([
            'rfid_code' => 'required|string|max:255',
        ]);

        $barang = Barang::where('kode_rfid', $request->rfid_code)->first();

        if (!$barang) {
            return response()->json(['error' => 'Tidak bisa meminjam barang dikarenakan tag belum terdaftar.'], 404);
        }

        return response()->json([
            'nama_barang' => $barang->nama_barang,
            'jumlah_tersedia' => $barang->jumlah,
            'kode_rfid' => $barang->kode_rfid,
            'success' => true
        ]);
    }
}
