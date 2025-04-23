<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use Illuminate\Http\Request;
use App\Http\Resources\MasyarakatResource;
use Illuminate\Support\Facades\Validator;

class MasyarakatController extends Controller
{
    public function index()
    {
        $masyarakat = Masyarakat::all();
        return MasyarakatResource::collection($masyarakat);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|unique:masyarakats',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki,Perempuan',
            // 'created_by' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $masyarakat = Masyarakat::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            // 'created_by' => $request->created_by,
        ]);

        return new MasyarakatResource($masyarakat);
    }

    public function show($id)
    {
        $masyarakat = Masyarakat::findOrFail($id);
        return new MasyarakatResource($masyarakat);
    }

    public function update(Request $request, $id)
    {
        $masyarakat = Masyarakat::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nik' => 'sometimes|required|unique:masyarakats,nik,' . $masyarakat->id,
            'nama' => 'sometimes|required|string|max:255',
            'jenis_kelamin' => 'sometimes|required|in:Laki,Perempuan',
            'updated_by' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $masyarakat->update($request->only(['nik', 'nama', 'jenis_kelamin', 'updated_by']));

        return new MasyarakatResource($masyarakat);
    }

    public function destroy($id)
    {
        $masyarakat = Masyarakat::findOrFail($id);
        $masyarakat->delete();

        return response()->json(['message' => 'Data masyarakat berhasil dihapus.']);
    }
}
