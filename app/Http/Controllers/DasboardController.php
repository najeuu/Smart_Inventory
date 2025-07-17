<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DasboardController extends Controller
{
    public function index()
    {
        // Barang tersedia, hampir habis, total, dan sedang dipinjam (sama seperti sebelumnya)
        $availableItems = Barang::where('jumlah', '>', 0)->sum('jumlah');
        $almostOutItems = Barang::where('jumlah', '<=', 3)->get();
        $totalItems = Barang::sum('jumlah');

        $barangs = Barang::with('peminjaman.pengembalians')->get();
        $borrowedItems = $barangs->reduce(function ($carry, $barang) {
            $totalDikembalikan = $barang->peminjaman->flatMap->pengembalians->sum('jumlah');
            $totalDipinjam = $barang->peminjaman->sum('total_barang');
            return $carry + ($totalDipinjam - $totalDikembalikan);
        }, 0);

        // Statistik peminjaman per minggu terakhir (7 hari ke belakang)
        $startDate = Carbon::now()->subDays(6)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $peminjamanStats = Peminjaman::select(DB::raw('DATE(tanggal_peminjaman) as tanggal'), DB::raw('count(*) as jumlah'))
            ->whereBetween('tanggal_peminjaman', [$startDate, $endDate])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Siapkan array tanggal 7 hari ke belakang
        $labels = [];
        $data = [];

        for ($i = 0; $i <= 6; $i++) {
            $tanggal = Carbon::now()->subDays(6 - $i)->format('Y-m-d');
            $labels[] = Carbon::parse($tanggal)->translatedFormat('d M');
            $jumlah = $peminjamanStats->firstWhere('tanggal', $tanggal)?->jumlah ?? 0;
            $data[] = $jumlah;
        }

        return view('dasboard', compact(
            'availableItems',
            'almostOutItems',
            'totalItems',
            'borrowedItems',
            'labels',
            'data'
        ));
    }

    public function getAlmostOutItems()
    {
        // Ambil nama barang yang hampir habis (jumlah <= 3)
        $almostOutItems = Barang::where('jumlah', '<=', 3)->pluck('nama_barang');

        // Ambil jumlah barang yang tersedia (jumlah > 0)
        $availableItemsCount = Barang::where('jumlah', '>', 0)->sum('jumlah');

        return response()->json([
            'almostOutItems' => $almostOutItems,
            'availableItemsCount' => $availableItemsCount,
        ]);
    }
}
