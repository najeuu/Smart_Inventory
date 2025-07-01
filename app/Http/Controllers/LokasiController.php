<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;

class LokasiController extends Controller
{
    public function generatePDF()
    {
        // Mengambil semua data lokasi beserta barang terkait
        $data = Lokasi::with('barang')->get(); // Mengambil data lokasi dan barang yang terkait

        // Buat PDF dari view
        $pdf = PDF::loadView('lokasi_pdf', compact('data'));

        // Download file PDF
        return $pdf->download('data_lokasi_dan_barang.pdf');
    }
    public function show()
    {
        $data = Lokasi::with('barangs')->get();
        return view('lokasi', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
        ]);

        Lokasi::create($request->all());

        return redirect()->route('lokasi');
    }

    public function update(Request $request, $id)
    {

        try {
            $lokasi = Lokasi::findOrFail($id);
            $lokasi->update($request->all());
            return redirect()->route('lokasi')->with('success', 'Data lokasi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->route('lokasi')->with('error', 'Gagal memperbarui data lokasi.');
        }
    }



    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('lokasi');
    }
}
