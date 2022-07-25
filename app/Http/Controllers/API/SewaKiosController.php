<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SewaKios;
use App\Models\RelasiKios;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class SewaKiosController extends Controller
{
    public function all(Request $request){
        $kios = SewaKios::with('RelasiKios')->where('user_id', Auth::user()->User->id)->get();

        foreach ($kios as $dataKios){
            $response[] = [
                'id_sewa' => $dataKios->id,
                'nama_kios' => $dataKios->RelasiKios->Kios->nama_kios,
                'tipe_kios' => $dataKios->RelasiKios->TarifKios->tipe,
                'tarif_kios' => $dataKios->RelasiKios->TarifKios->harga,
                'tempat_kios' => $dataKios->RelasiKios->Kios->tempat,
                'lokasi_kios' => $dataKios->RelasiKios->Lokasi->nama_lokasi
            ];
        };

        if($response)
            return ResponseFormatter::success($response, 'Data Sewa Kios Berhasil di Ambil');
        else
            return ResponseFormatter::error(null, 'Data Sewa Kios Tidak Ada', 404);
    }
}
