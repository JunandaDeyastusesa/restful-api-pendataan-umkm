<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UmkmController extends Controller
{

    public function index()
    {
        return response()->json(Umkm::all());
    }

    public function show($id)
    {
        $umkm = Umkm::find($id);

        if (!$umkm) {
            return response()->json(['message' => 'UMKM tidak terdaftar'], 404);
        }
        return response()->json($umkm);
    }

    public function store(Request $request)
    {
        $request->validate([
            'masyarakat_id' => 'required|integer',
            'nama_usaha' => 'required|string|max:255',
            'alamat_usaha' => 'required|string|max:255',
            'jenis_usaha' => 'required|in:jasa,fnb',
        ]);

        $masyarakat = Http::get(env('MASYARAKAT_SERVICE_URL') . "/api/masyarakat/{$request->masyarakat_id}");

        if ($masyarakat->failed()) {
            return response()->json(['message' => 'Masyarakat ID tidak ditemukan'], 500);
        }

        $umkm = Umkm::create([
            'masyarakat_id' => $request->masyarakat_id,
            'nama_usaha' => $request->nama_usaha,
            'alamat_usaha' => $request->alamat_usaha,
            'jenis_usaha' => $request->jenis_usaha,
        ]);

        return response()->json($umkm, 201);
    }

    public function update(Request $request, $id)
    {
        $umkm = Umkm::findOrFail($id);

        $request->validate([
            'masyarakat_id' => 'nullable|numeric',
            'nama_usaha' => 'nullable|string',
            'alamat_usaha' => 'nullable|string',
            'jenis_usaha' => 'nullable|in:jasa,fnb',
        ]);

        if ($request->filled('masyarakat_id')) {
            $masyarakat = Http::get(env('MASYARAKAT_SERVICE_URL') . "/api/masyarakat/{$request->masyarakat_id}");

            if ($masyarakat->failed()) {
                return response()->json(['message' => 'Masyarakat ID tidak ditemukan'], 500);
            }
        }

        $umkm->update([
            'masyarakat_id' => $request->masyarakat_id,
            'nama_usaha' => $request->nama_usaha,
            'alamat_usaha' => $request->alamat_usaha,
            'jenis_usaha' => $request->jenis_usaha,
        ]);

        return response()->json($umkm);
    }


    public function destroy($id)
    {
        $umkm = Umkm::find($id);

        if (!$umkm) {
            return response()->json(['message' => 'UMKM tidak terdaftar'], 404);
        }

        $umkm->delete();

        return response()->json(['message' => 'Data UMKM berhasil dihapus.']);
    }
}
