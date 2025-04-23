<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::all();
        return response()->json($transaksis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cust_id' => 'required|integer',
            'produk_id' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);

        $cust = Http::get(env('MASYARAKAT_SERVICE_URL') . "/api/masyarakat/{$request->cust_id}");
        if ($cust->failed()) {
            return response()->json(['message' => 'Masyarakat ID tidak ditemukan'], 500);
        }

        $produk = Http::get(env('PRODUK_UMKM_SERVICE_URL') . "/api/produk-umkm/{$request->produk_id}");
        if ($produk->failed()) {
            return response()->json(['message' => 'Produk ID tidak ditemukan'], 500);
        }

        $produkData = $produk->json();

        if (!isset($produkData['harga_produk'])) {
            return response()->json(['message' => 'Harga produk tidak tersedia dari service'], 500);
        }

        $hargaSatuan = (int) $produkData['harga_produk'];
        $jumlah = (int) $request->jumlah;
        $totalHarga = $hargaSatuan * $jumlah;

        $transaksi = Transaksi::create([
            'cust_id' => $request->cust_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $jumlah,
            'total_harga' => $totalHarga,
        ]);

        return response()->json($transaksi, 201);
    }

    public function show($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        return response()->json($transaksi);
    }


    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $request->validate([
            'cust_id' => 'nullable|integer',
            'produk_id' => 'nullable|integer',
            'jumlah' => 'nullable|integer|min:1',
        ]);

        if ($request->filled('cust_id')) {
            $cust = Http::get(env('MASYARAKAT_SERVICE_URL') . "/api/masyarakat/{$request->cust_id}");
            if ($cust->failed()) {
                return response()->json(['message' => 'Masyarakat ID tidak ditemukan'], 500);
            }
            
            $transaksi->cust_id = $request->cust_id;
        }

        if ($request->filled('produk_id')) {
            $produk = Http::get(env('PRODUK_UMKM_SERVICE_URL') . "/api/produk-umkm/{$request->produk_id}");
            if ($produk->failed()) {
                return response()->json(['message' => 'Produk ID tidak ditemukan'], 500);
            }

            $produkData = $produk->json();
            if (!isset($produkData['harga_produk'])) {
                return response()->json(['message' => 'Harga produk tidak tersedia dari service'], 500);
            }

            $transaksi->produk_id = $request->produk_id;
            $hargaProduk = (int) $produkData['harga_produk'];
        } else {
            $produk = Http::get(env('PRODUK_UMKM_SERVICE_URL') . "/api/produk-umkm/{$transaksi->produk_id}");
            $produkData = $produk->json();
            $hargaProduk = (int) ($produkData['harga_produk'] ?? 0);
        }

        if ($request->filled('jumlah')) {
            $transaksi->jumlah = $request->jumlah;
        }

        $transaksi->total_harga = $hargaProduk * $transaksi->jumlah;

        $transaksi->save();

        return response()->json($transaksi);
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        $transaksi->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus.']);
    }
}
