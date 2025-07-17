<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;

class RiwayatController extends Controller
{
    public function index()
    {
        $barangs = Barang::with(['peminjaman.pengembalians'])->get();

        $riwayat = $barangs->map(function ($barang) {
            $totalDikembalikan = $barang->peminjaman->flatMap->pengembalians->sum('jumlah');
            $totalDipinjam = $barang->peminjaman->sum('total_barang') - $totalDikembalikan;
            $jumlahPeminjaman = $barang->peminjaman->count();
            $jumlahPengembalian = $barang->peminjaman->flatMap->pengembalians->count();

            $totalBarang = $barang->jumlah + $totalDipinjam;

            if ($totalDipinjam == 0) {
                $status = 'Tersedia';
            } elseif ($barang->jumlah == 0) {
                $status = 'Dipinjam Penuh';
            } else {
                $status = 'Sebagian Dipinjam';
            }

            return [
                'id' => $barang->id,
                'nama_barang' => $barang->nama_barang,
                'total_barang' => $totalBarang,
                'stok_barang' => $barang->jumlah,
                'total_dipinjam' => $totalDipinjam,
                'total_dikembalikan' => $totalDikembalikan,
                'status' => $status,
                'jumlah_transaksi_peminjaman' => $jumlahPeminjaman,
                'jumlah_transaksi_pengembalian' => $jumlahPengembalian,
            ];
        });

        return view('riwayat', compact('riwayat'));
    }

    public function show(Request $request, $id)
    {
        $barang = Barang::with(['peminjaman.pengembalians', 'kategori', 'lokasi'])->findOrFail($id);

        $query = $barang->peminjaman();

        // Filter berdasarkan nama mahasiswa
        if ($request->filled('search')) {
            $query->where('nama_mahasiswa', 'like', '%' . $request->search . '%');
        }

        $peminjamanList = $query->with(['pengembalians', 'user'])->get();

        $riwayatPeminjaman = $peminjamanList->map(function ($pinjam) {
            $jumlahDipinjam = $pinjam->total_barang + $pinjam->pengembalians->sum('jumlah');
            $jumlahDikembalikan = $pinjam->pengembalians->sum('jumlah');
            $sisa = $jumlahDipinjam - $jumlahDikembalikan;

            if ($jumlahDikembalikan == 0) {
                $status = 'Belum dikembalikan';
            } elseif ($sisa > 0) {
                $status = 'Sebagian dikembalikan';
            } else {
                $status = 'Sudah dikembalikan';
            }

            return [
                'nama_mahasiswa' => $pinjam->user->nama_mahasiswa ?? '-',
                'nim' => $pinjam->user->nim ?? '-',
                'jumlah_pinjam' => $jumlahDipinjam,
                'jumlah_dikembalikan' => $jumlahDikembalikan,
                'tanggal_pinjam' => $pinjam->tanggal_peminjaman,
                'tanggal_pengembalian_terakhir' => $pinjam->pengembalians->last()?->tanggal_pengembalian,
                'status' => $status,
            ];
        });

        if ($request->has('download')) {
            $pdf = PDF::loadView('pdf.detail_riwayat_barang', compact('barang', 'riwayatPeminjaman'));
            return $pdf->download('riwayat_barang_' . $barang->nama_barang . '.pdf');
        }

        return view('riwayat-detail-barang', compact('barang', 'riwayatPeminjaman'));
    }
}
