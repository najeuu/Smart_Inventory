<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Lokasi;
use PDF;

class DataBarangController extends Controller
{
    public function index()
    {
        // Mengambil semua data barang dari model Barang
        $data = Barang::paginate(10);

        // Mengirim data ke view 'laporan'
        return view('laporan', compact('data'));
    }

    public function downloadPDF()
    {
        \Log::info('Download PDF method called');
        $data = Barang::all();
        $pdf = PDF::loadView('pdf.laporan_barang', compact('data'));
        return $pdf->download('laporan_barang.pdf');
    }

    public function show()
    {
        $data = Barang::get();
        $lokasi = Lokasi::all();
        return view('data_barang', compact('data', 'lokasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_rfid' => 'required|unique:barangs,kode_rfid',
            'nama_barang' => 'required',
            'jumlah' => 'required|integer|min:1',
            'lokasi_id' => 'required|exists:lokasi,id',
        ], [
            'kode_rfid.required' => 'RFID Tag harus diisi',
            'kode_rfid.unique' => 'RFID Tag sudah digunakan',
            'nama_barang.required' => 'Nama barang harus diisi',
            'jumlah.required' => 'Jumlah harus diisi',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah barang harus lebih dari 0',
            'lokasi_id.required' => 'Lokasi harus diisi',
        ]);

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'jumlah' => $request->jumlah,
            'lokasi_id' => $request->lokasi_id,
            'kode_rfid' => $request->kode_rfid,
        ]);

        return redirect()->route('data_barang')->with('success', 'Barang baru berhasil ditambahkan ke dalam sistem.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'lokasi_id' => 'required|exists:lokasi,id',
            'kode_rfid' => 'required|string|max:255|unique:barangs,kode_rfid,' . $id,
        ], [
            'kode_rfid.required' => 'RFID Tag harus diisi',
            'kode_rfid.unique' => 'RFID Tag sudah digunakan',
            'nama_barang.required' => 'Nama barang harus diisi',
            'jumlah.required' => 'Jumlah harus diisi',
            'jumlah.integer' => 'Jumlah harus berupa angka',
            'jumlah.min' => 'Jumlah barang harus lebih dari 0',
            'lokasi_id.required' => 'Lokasi harus diisi',
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
}
