<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Barang;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    // method mencari data peminjaman berdasarkan NIM
    public function cari(Request $request)
    {
        $nim = $request->nim;

        // Ambil data peminjaman yang belum dikembalikan
        $peminjaman = Peminjaman::where('nim', $nim)
            ->whereDoesntHave('pengembalian') // Pastikan tidak ada pengembalian
            ->get();

        // Map data barang
        $barangDipinjam = $peminjaman->map(function ($pinjam) {
            return [
                'id' => $pinjam->id,
                'jenis_barang' => $pinjam->jenis_barang,
                'total_barang' => $pinjam->total_barang,
            ];
        });

        return view('pengembalian', compact('nim', 'barangDipinjam'));
    }

    // method memproses pengembalian barang
    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|exists:peminjaman,nim',
            'barang_ids' => 'required|array',
            'barang_ids.*' => 'exists:peminjaman,id',
            'tanggal_pengembalian' => 'required|date',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->barang_ids as $peminjamanId) {
                $peminjaman = Peminjaman::findOrFail($peminjamanId);

                // Create pengembalian record
                Pengembalian::create([
                    'nim' => $request->nim,
                    'peminjaman_id' => $peminjamanId,
                    'jenis_barang' => $peminjaman->jenis_barang,
                    'jumlah' => $peminjaman->total_barang,
                    'tanggal_pengembalian' => $request->tanggal_pengembalian,
                ]);

                // Update stock
                $barang = Barang::where('nama_barang', $peminjaman->jenis_barang)->first();
                if ($barang) {
                    $barang->increaseQuantity($peminjaman->total_barang);
                }
            }

            DB::commit();
            return redirect()->route('pengembalian.cari', ['nim' => $request->nim])
                ->with('success', 'Barang berhasil dikembalikan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }

    public function checkRegisteredRFID($kodeRFID)
    {
        $barang = Barang::where('kode_rfid', $kodeRFID)->first();

        if (!$barang) {
            return response()->json([
                'exists' => false
            ]);
        }

        // Get borrowed items for this NIM
        $borrowedItems = Peminjaman::where('nim', request('nim'))
            ->whereDoesntHave('pengembalian')
            ->where('jenis_barang', $barang->nama_barang)
            ->get()
            ->map(function ($pinjam) {
                return [
                    'id' => $pinjam->id,
                    'nama_barang' => $pinjam->jenis_barang,
                    'jumlah' => $pinjam->total_barang,
                    'is_borrowed' => true
                ];
            });

        return response()->json([
            'exists' => true,
            'barang' => $borrowedItems
        ]);
    }
}
