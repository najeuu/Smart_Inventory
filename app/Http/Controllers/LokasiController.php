<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lokasi;
use App\Models\Barang;

class LokasiController extends Controller
{
    public function generatePDF()
    {
        $data = Lokasi::with('barang')->get();

        $pdf = PDF::loadView('lokasi_pdf', compact('data'));

        return $pdf->download('data_lokasi_dan_barang.pdf');
    }
    public function show(Request $request)
    {
        $search = $request->input('search');
        $filterLokasi = $request->input('filter_lokasi');

        $lokasiList = Lokasi::all();

        $lokasiQuery = Lokasi::with(['barangs' => function ($query) use ($search) {
            if ($search) {
                $query->where('nama_barang', 'like', '%' . $search . '%');
            }
        }]);

        if ($filterLokasi) {
            $lokasiQuery->where('id', $filterLokasi);
        }

        $data = $lokasiQuery->paginate(10)->withQueryString();

        $noBarangFound = $search || $filterLokasi
            ? $data->every(fn($lokasi) => $lokasi->barangs->isEmpty())
            : false;

        return view('lokasi', [
            'data' => $data,
            'search' => $search,
            'filterLokasi' => $filterLokasi,
            'lokasiList' => $lokasiList,
            'noBarangFound' => $noBarangFound
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required|string|max:255',
        ]);

        Lokasi::create($request->all());

        return redirect()->route('lokasi')->with('success', 'Lokasi berhasil ditambahkan.');
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
        try {
            $lokasi = Lokasi::findOrFail($id);
            $lokasi->delete();
            return redirect()->route('lokasi')->with('success', 'Lokasi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('lokasi')->with('error', 'Gagal menghapus lokasi.');
        }
    }
}
