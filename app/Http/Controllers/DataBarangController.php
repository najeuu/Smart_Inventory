<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Barang;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Exports\BarangExport;
use App\Models\KategoriBarang;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Peminjaman;

class DataBarangController extends Controller
{
    public function index()
    {
        // Mengambil semua data barang dari model Barang
        $data = Barang::with('lokasi', 'kategori')->orderBy('created_at', 'desc')->get();

        // Mengirim data ke view 'laporan'
        return view('laporan', compact('data'));
    }

    public function downloadLaporan(Request $request)
    {
        $data = Barang::with('lokasi')->orderBy('created_at', 'desc')->get();

        $tanggalUnduh = now()->format('d-m-Y');
        $user = auth()->user();

        return PDF::loadView('pdf.laporan_barang', [
            'data' => $data,
            'tanggalUnduh' => $tanggalUnduh,
            'user' => $user
        ])->download('laporan_barang.pdf');
    }

    // Menampilkan halaman data barang untuk admin (tabel)
    public function showAdmin()
    {
        $data = Barang::with('lokasi', 'kategori')->paginate(10);;
        $lokasi = Lokasi::all();
        $kategoris = KategoriBarang::all();
        return view('data_barang', compact('data', 'lokasi', 'kategoris'));
    }


    // Menampilkan dashboard kategori alat untuk pengguna
    public function showUser()
    {
        $kategoris = KategoriBarang::all();
        $kategori = null;
        $barangs = null;
        return view('databarang-pengguna', compact('kategoris', 'kategori', 'barangs'));
    }

    // Menampilkan barang per kategori untuk pengguna
    public function showByKategori($id)
    {
        $kategori = KategoriBarang::findOrFail($id);
        $barangs = Barang::where('kategori_id', $id)->get();

        return view('databarang-pengguna', compact('kategori', 'barangs'));
    }

    public function show()
    {
        $data = Barang::with('lokasi', 'kategori')->get();
        $lokasi = Lokasi::all();
        $kategoris = KategoriBarang::all();
        return view('data_barang', compact('data', 'lokasi', 'kategoris'));
    }

    // Tambahkan method baru di DataBarangController

    public function checkRFIDExists($kodeRFID)
    {
        $exists = Barang::where('kode_rfid', $kodeRFID)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kategori_id' => 'required|exists:kategori_barangs,id',
            'lokasi_id' => 'required|exists:lokasi,id',
            'kode_rfid' => 'required|string|max:255',
        ]);

        // Validasi RFID manual
        if (Barang::where('kode_rfid', $request->kode_rfid)->exists()) {
            return redirect()->route('data_barang')
                ->with('kode_rfid_terdaftar', 'Kode RFID telah didaftarkan. Silahkan coba kode yang lain.');
        }

        $barang = new Barang();
        $barang->nama_barang = $request->nama_barang;
        $barang->jumlah = $request->jumlah;
        $barang->kategori_id = $request->kategori_id;
        $barang->lokasi_id = $request->lokasi_id;
        $barang->deskripsi = $request->deskripsi;
        $barang->kode_rfid = $request->kode_rfid;

        if ($request->hasFile('gambar')) {
            $barang->gambar = $request->file('gambar')->store('gambar_barang', 'public');
        }

        $barang->save();

        return redirect()->route('data_barang')->with('success', 'Barang berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'lokasi_id' => 'required|exists:lokasi,id',
            'kategori_id' => 'required|exists:kategori_barangs,id',
            'kode_rfid' => 'required|string|max:255|unique:barangs,kode_rfid,' . $id,
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'kode_rfid.unique' => 'Kode RFID telah didaftarkan. Silahkan coba kode yang lain.',
        ]);

        $barang = Barang::findOrFail($id);

        // Update data
        $barang->nama_barang = $request->nama_barang;
        $barang->jumlah = $request->jumlah;
        $barang->lokasi_id = $request->lokasi_id;
        $barang->kategori_id = $request->kategori_id;
        $barang->kode_rfid = $request->kode_rfid;
        $barang->deskripsi = $request->deskripsi;

        if ($request->hasFile('gambar')) {
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }

            $barang->gambar = $request->file('gambar')->store('gambar_barang', 'public');
        }

        $barang->save();

        return redirect()->route('data_barang')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        $peminjamans = Peminjaman::where('barang_id', $barang->nama_barang)->get();

        foreach ($peminjamans as $pinjam) {
            if ($pinjam->pengembalian === null) {
                return redirect()->route('data_barang')
                    ->with('error', 'Barang masih dipinjam dan belum dikembalikan, tidak bisa dihapus.');
            }
        }

        foreach ($peminjamans as $pinjam) {
            if ($pinjam->pengembalian) {
                $pinjam->pengembalian->delete();
            }
            $pinjam->delete();
        }

        if ($barang->gambar && \Storage::disk('public')->exists($barang->gambar)) {
            \Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('data_barang')->with('success', 'Data barang berhasil dihapus.');
    }

    public function saveRfidTag(Request $request)
    {
        $request->validate([
            'kode_rfid' => 'required|string|max:255|unique:barangs,kode_rfid',
        ]);

        session(['kode_rfid' => $request->kode_rfid]);

        return response()->json(['message' => 'RFID tag saved to session.']);
    }

    public function getBarangByRFID($kodeRFID)
    {
        $barang = Barang::where('kode_rfid', $kodeRFID)->first();
        return response()->json([
            'success' => !is_null($barang),
            'data' => $barang
        ]);
    }
}
