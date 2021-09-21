<?php

namespace App\Http\Controllers;

use App\Models\Kk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KkController extends Controller
{    
   
    public function index()
    {
        
        $kks = Kk::latest()->get();

        
        return response()->json([
            'success' => true,
            'message' => 'Daftar data kartu keluarga',
            'data'    => $kks
        ], 200);

    }
    
   
    public function show($id)
    {
        $kks = Kk::findOrfail($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Kartu Keluarga',
            'data'    => $kks
        ], 200);

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nik'   => 'required',
            'nama_kepala' => 'required',
            'jumlah_keluarga' => 'required',
            'rtrw' => 'required',
            'alamat' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $kks = Kk::create([
            'nik'     => $request->nik,
            'nama_kepala'   => $request->nama_kepala,
            'jumlah_keluarga'   => $request->jumlah_keluarga,
            'rtrw'   => $request->rtrw,
            'alamat'   => $request->alamat
        ]);

        if($kks) {

            return response()->json([
                'success' => true,
                'message' => 'Data kartu keluarga berhasil disimpan',
                'data'    => $kks 
            ], 201);

        } 

        return response()->json([
            'success' => false,
            'message' => 'Data kartu keluarga gagal disimpan',
        ], 409);

    }
    
    public function update(Request $request, Kk $kk)
    {
        $validator = Validator::make($request->all(), [
            'nik'   => 'required',
            'nama_kepala' => 'required',
            'jumlah_keluarga' => 'required',
            'rtrw' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $kks = Kk::findOrFail($kk->id);

        if($kks) {

            $kks->update([
                'nik'     => $request->nik,
                'nama_kepala'   => $request->nama_kepala,
                'jumlah_keluarga'   => $request->jumlah_keluarga,
                'rtrw'   => $request->rtrw,
                'alamat'   => $request->alamat
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data kartu keluarga berhasil diupdate!',
                'data'    => $kks
            ], 200);

        }

        return response()->json([
            'success' => false,
            'message' => 'Data kartu keluarga tidak ditemukan',
        ], 404);

    }
    
    public function destroy($id)
    {
        $kks = Kk::findOrfail($id);

        if($kks) {

            $kks->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data kartu keluarga berhasil dihapus!',
            ], 200);

        }

        return response()->json([
            'success' => false,
            'message' => 'Data kartu keluarga tidak ditemukan!',
        ], 404);
    }
}