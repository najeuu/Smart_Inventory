<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Barang;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['barang', 'pengembalians'])
            ->where('user_id', auth()->id())
            ->orderBy('tanggal_peminjaman', 'asc')
            ->get();

        $grouped = [];

        foreach ($peminjaman as $pinjam) {
            $tanggal = $pinjam->tanggal_peminjaman;
            $jumlahDikembalikan = $pinjam->pengembalians->sum('jumlah');
            $sisa = $pinjam->total_barang - $jumlahDikembalikan;

            if ($sisa > 0) {
                if (!isset($grouped[$tanggal])) {
                    $grouped[$tanggal] = [
                        'tanggal_pinjam' => $tanggal,
                        'items' => []
                    ];
                }

                $grouped[$tanggal]['items'][] = [
                    'id' => $pinjam->id,
                    'nama_barang' => $pinjam->barang->nama_barang ?? 'N/A',
                    'total_barang' => $sisa
                ];
            }
        }

        $barangDipinjam = array_values($grouped); // numerik array untuk Blade

        return view('pengembalian', compact('barangDipinjam'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_ids' => 'required|array',
            'jumlah_dikembalikan' => 'required|array',
            'tanggal_pengembalian' => 'required|date',
        ]);

        // ✅ Validasi tambahan: pastikan setidaknya ada satu barang yang dikembalikan
        $totalPengembalian = 0;
        foreach ($request->jumlah_dikembalikan as $jumlah) {
            $totalPengembalian += (int) $jumlah;
        }

        if ($totalPengembalian <= 0) {
            return back()->with('error', 'Harap isi setidaknya satu jumlah barang yang ingin dikembalikan.');
        }

        DB::beginTransaction();
        try {
            foreach ($request->barang_ids as $index => $peminjamanId) {
                $jumlahKembali = (int) $request->jumlah_dikembalikan[$index];

                // Skip jika jumlah tidak valid
                if ($jumlahKembali <= 0) {
                    continue;
                }

                $peminjaman = Peminjaman::with(['barang', 'pengembalians'])
                    ->where('id', $peminjamanId)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();

                // ✅ Validasi tanggal pengembalian tidak boleh lebih awal dari tanggal pinjam
                if (\Carbon\Carbon::parse($request->tanggal_pengembalian)->lt($peminjaman->tanggal_peminjaman)) {
                    throw new \Exception("Tanggal pengembalian tidak boleh lebih awal dari tanggal peminjaman ({$peminjaman->tanggal_peminjaman}) untuk barang " . ($peminjaman->barang->nama_barang ?? 'N/A') . ".");
                }

                $sudahDikembalikan = $peminjaman->pengembalians->sum('jumlah');
                $totalBelumDikembalikanSaatIni = $peminjaman->total_barang - $sudahDikembalikan;

                if ($jumlahKembali > $totalBelumDikembalikanSaatIni) {
                    throw new \Exception("Jumlah pengembalian ({$jumlahKembali}) melebihi jumlah yang belum dikembalikan ({$totalBelumDikembalikanSaatIni}) untuk barang " . ($peminjaman->barang->nama_barang ?? 'N/A') . ".");
                }

                // Simpan data pengembalian
                Pengembalian::create([
                    'peminjaman_id' => $peminjaman->id,
                    'barang_id' => $peminjaman->barang_id,
                    'jumlah' => $jumlahKembali,
                    'tanggal_pengembalian' => $request->tanggal_pengembalian,
                ]);

                // Update stok barang
                $barang = Barang::find($peminjaman->barang_id);
                if ($barang) {
                    $barang->increaseQuantity($jumlahKembali);
                }
            }

            DB::commit();
            return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil diproses.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Pengembalian failed: ' . $e->getMessage(), ['exception' => $e]);
            return back()->with('error', 'Gagal memproses pengembalian: ' . $e->getMessage());
        }
    }
}
