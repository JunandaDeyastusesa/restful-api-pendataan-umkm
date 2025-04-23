<?php

namespace App\Http\Controllers;

use App\Models\ProdukUmkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProdukUmkmController extends Controller
{

    public function index()
    {
        $produkUmkm = ProdukUmkm::all();
        return response()->json($produkUmkm);
    }


    public function store(Request $request)
    {
        $request->validate([
            'umkm_id' => 'required|integer',
            'nama_produk' => 'required|string|max:255',
            'harga_produk' => 'required|numeric|min:0',
        ]);

        $umkm = Http::get(env('UMKM_SERVICE_URL') . "/api/umkm/{$request->umkm_id}");

        if ($umkm->failed()) {
            return response()->json(['message' => 'UMKM ID tidak ditemukan'], 500);
        }

        $produkUmkm = ProdukUmkm::create(
            [
                'umkm_id' => $request->umkm_id,
                'nama_produk' => $request->nama_produk,
                'harga_produk' => $request->harga_produk,
            ]
        );

        return response()->json($produkUmkm, 201);
    }

    public function show($id)
    {
        $produkUmkm = ProdukUmkm::find($id);

        if (!$produkUmkm) {
            return response()->json(['message' => 'Produk tidak terdaftar'], 404);
        }
        return response()->json($produkUmkm);
    }

    public function update(Request $request, $id)
    {

        $produkUmkm = ProdukUmkm::findOrFail($id);

        $request->validate([
            'umkm_id' => 'nullable|numeric',
            'nama_produk' => 'nullable|string',
            'harga_produk' => 'nullable|numeric',
        ]);

        if ($request->filled('umkm_id')) {
            $response = Http::get(env('UMKM_SERVICE_URL') . "/api/umkm/{$request->umkm_id}");

            if ($response->failed()) {
                return response()->json(['message' => 'UMKM ID tidak ditemukan'], 404);
            }
        }

        $produkUmkm->update([
            'umkm_id' => $request->umkm_id,
            'nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
        ]);

        return response()->json($produkUmkm);
    }

    public function destroy($id)
    {

        $produkUmkm = ProdukUmkm::find($id);

        if (!$produkUmkm) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $produkUmkm->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
