<?php

namespace App\Http\Controllers\Api\Pustakawan\Buku;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Buku;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    public function createBuku(Request $request) 
    {
        $this->validate($request, [
            'judul_buku' => 'required',
            'pengarang_buku' => 'required',
            'penerbit_buku' => 'required',
            'tahun_terbit_buku' => 'required',
            'jumlah_halaman_buku' => 'required',
            'stok_buku' => 'required',
            'nama_rak' => 'required',
            'lokasi_rak' => 'required'
        ]);

        if($request->hasFile('foto_buku')){
            $resource = $request->file('foto_buku');
            $name = Carbon::now()->timestamp."_".$resource->getClientOriginalName();
            $userId = Auth::user()->id;
            $url = "/storage/foto_buku/".$userId."/".$name;
            $resource->move(\base_path() ."/public/storage/foto_buku/".$userId, $name);
            
            Buku::create([
                'foto_buku' => $url,
                'judul_buku' => $request['judul_buku'],
                'pengarang_buku' => $request['pengarang_buku'],
                'penerbit_buku' => $request['penerbit_buku'],
                'tahun_terbit_buku' => $request['tahun_terbit_buku'],
                'jumlah_halaman_buku' => $request['jumlah_halaman_buku'],
                'stok_buku' => $request['stok_buku'],
                'nama_rak' => $request['nama_rak'],
                'lokasi_rak' => $request['lokasi_rak'],
                'id_prefix' => '4'
            ]);
            
            return response()->json([
              'status' => 'success',
              'message' => 'Buku telah berhasil ditambahkan.'
            ], 200);

          } else {

            Buku::create([
                'judul_buku' => $request['judul_buku'],
                'pengarang_buku' => $request['pengarang_buku'],
                'penerbit_buku' => $request['penerbit_buku'],
                'tahun_terbit_buku' => $request['tahun_terbit_buku'],
                'jumlah_halaman_buku' => $request['jumlah_halaman_buku'],
                'stok_buku' => $request['stok_buku'],
                'nama_rak' => $request['nama_rak'],
                'lokasi_rak' => $request['lokasi_rak'],
                'id_prefix' => '4'
            ]);
        
            return response()->json([
                'status' => 'success',
                'message' => 'Buku telah berhasil ditambahkan, tanpa foto buku.'
            ], 200);

        }
    }
}
