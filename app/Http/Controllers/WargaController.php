<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WargaController extends Controller
{    
   
    public function index()
    {
        
        $wargas = Warga::latest()->get();

        
        return response()->json([
            'success' => true,
            'message' => 'Daftar data warga',
            'data'    => $wargas
        ], 200);

    }
    
   
    public function show($id)
    {
        $warga = Warga::findOrfail($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Warga',
            'data'    => $warga
        ], 200);

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_warga'   => 'required',
            'alamat' => 'required',
            'pekerjaan' => 'required',
            'no_telp' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $warga = Warga::create([
            'nama_warga'     => $request->nama_warga,
            'alamat'   => $request->alamat,
            'pekerjaan'   => $request->pekerjaan,
            'no_telp'   => $request->no_telp
        ]);

        if($warga) {

            return response()->json([
                'success' => true,
                'message' => 'Data warga berhasil disimpan',
                'data'    => $warga 
            ], 201);

        } 

        return response()->json([
            'success' => false,
            'message' => 'Data gagal disimpan',
        ], 409);

    }
    
    public function update(Request $request, Warga $warga)
    {
        $validator = Validator::make($request->all(), [
            'nama_warga'   => 'required',
            'alamat' => 'required',
            'pekerjaan' => 'required',
            'no_telp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $warga = Warga::findOrFail($warga->id);

        if($warga) {

            $warga->update([
            'nama_warga'     => $request->nama_warga,
            'alamat'   => $request->alamat,
            'pekerjaan'   => $request->pekerjaan,
            'no_telp'   => $request->no_telp
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data warga berhasil diupdate!',
                'data'    => $warga
            ], 200);

        }

        return response()->json([
            'success' => false,
            'message' => 'Data warga tidak ditemukan',
        ], 404);

    }
    
    public function destroy($id)
    {
        $warga = Warga::findOrfail($id);

        if($warga) {

            $warga->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data warga berhasil dihapus!',
            ], 200);

        }

        return response()->json([
            'success' => false,
            'message' => 'Data warga tidak ditemukan!',
        ], 404);
    }
}