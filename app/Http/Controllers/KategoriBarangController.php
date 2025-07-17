<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBarang;

class KategoriBarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterKategori = $request->input('filter_kategori');

        $query = KategoriBarang::query();
        if ($filterKategori) {
            $query->where('id', $filterKategori);
        }

        $kategoriList = KategoriBarang::all();

        $kategoriData = $query->with(['barangs' => function ($q) use ($search) {
            if ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%');
            }
        }])->get();

        // TIDAK MEMFILTER lagi kategori yang tidak punya barang
        $currentPage = request()->get('page', 1);
        $perPage = 10;
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $kategoriData->forPage($currentPage, $perPage),
            $kategoriData->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $noBarangFound = ($search || $filterKategori) && $kategoriData->every(function ($kategori) {
            return $kategori->barangs->isEmpty();
        });

        return view('kategori', [
            'data' => $paginated,
            'kategoriList' => $kategoriList,
            'search' => $search,
            'filterKategori' => $filterKategori,
            'noBarangFound' => $noBarangFound,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        KategoriBarang::create($request->all());
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriBarang::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriBarang::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
