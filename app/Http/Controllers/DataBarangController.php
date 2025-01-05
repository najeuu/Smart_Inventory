<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Lokasi;
use PDF;
use App\Exports\BarangExport;
use Maatwebsite\Excel\Facades\Excel;

class DataBarangController extends Controller
{
    public function index()
    {
        // Mengambil semua data barang dari model Barang
        $data = Barang::with('lokasi')->paginate(10);

        // Mengirim data ke view 'laporan'
        return view('laporan', compact('data'));
    }

    public function downloadLaporan(Request $request)
    {
        $data = $this->getDataForReport($request);

        // Validasi format laporan
        if ($request->format === 'pdf') {
            // Mengunduh PDF
            return PDF::loadView('pdf.laporan_barang', compact('data'))->download('laporan_barang.pdf');
        } elseif ($request->format === 'excel') {
            // Mengunduh Excel
            return Excel::download(new BarangExport($data), 'laporan_barang.xlsx');
        } else {
            // Kembali jika format tidak valid
            return back()->with('error', 'Pilih format laporan');
        }
    }

    private function getDataForReport(Request $request)
    {
        // Ambil data barang dan filter berdasarkan tanggal jika ada
        $data = Barang::with('lokasi');

        if ($this->validateDateRange($request->tanggal_awal, $request->tanggal_akhir)) {
            $data = $data->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        return $data->get();
    }

    private function validateDateRange($startDate, $endDate)
    {
        if (!empty($startDate) && !empty($endDate)) {
            if (strtotime($startDate) > strtotime($endDate)) {
                return back()->with('error', 'Rentang tanggal tidak valid. Tanggal akhir harus setelah tanggal awal.');
            }
            return true;
        }
        return true; // Jika tidak ada tanggal, tampilkan semua data
    }

    public function show()
    {
        $data = Barang::get();
        $lokasi = Lokasi::all();
        return view('data_barang', compact('data', 'lokasi'));
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
            'kode_rfid' => 'required|string|max:255|unique:barangs,kode_rfid',
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'lokasi_id' => 'required|exists:lokasi,id',
        ]);

        try {
            $barang = Barang::create([
                'nama_barang' => $request->nama_barang,
                'jumlah' => $request->jumlah,
                'lokasi_id' => $request->lokasi_id,
                'kode_rfid' => str_replace(' ', '', $request->kode_rfid),
            ]);

            return redirect()->route('data_barang')->with('success', 'Barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('data_barang')->with('error', 'Gagal menambahkan barang: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'lokasi_id' => 'required|exists:lokasi,id',
            'kode_rfid' => 'required|string|max:255|unique:barangs,kode_rfid,' . $id,
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'lokasi_id' => $request->lokasi_id,
            'kode_rfid' => $request->kode_rfid,
        ]);

        return redirect()->route('data_barang')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        // Cek apakah barang sedang dipinjam
        if ($barang->peminjaman()->exists()) {
            return redirect()->route('data_barang')->with('error', 'Barang sedang dipinjam, tidak dapat dihapus.');
        }

        $barang->delete();

        return redirect()->route('data_barang')->with('success', 'Data barang berhasil dihapus dari sistem.');
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
