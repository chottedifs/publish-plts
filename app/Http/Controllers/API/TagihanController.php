<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\MasterStatus;
use Illuminate\Http\Request;
use Auth;

class TagihanController extends Controller
{
    public function all(Request $request){
        $tagihan = Tagihan::with('SewaKios','MasterStatus')->where('user_id', Auth::user()->User->id)->get();

        foreach ($tagihan as $dataTagihan){
            $response[] = [
                'id_sewa' => $dataTagihan->SewaKios->id,
                'id_tagihan' => $dataTagihan->id,
                'kode_tagihan' => $dataTagihan->kode_tagihan,
                'nama_penyewa' => $dataTagihan->User->nama_lengkap,
                'no_rekening' => $dataTagihan->User->rekening,
                'nama_kios' => $dataTagihan->SewaKios->RelasiKios->Kios->nama_kios,
                'lokasi_kios' => $dataTagihan->SewaKios->RelasiKios->Lokasi->nama_lokasi,
                'periode' => date('m-Y', strtotime($dataTagihan->periode)),
                'tagihan_kios' => $dataTagihan->tagihan_kios,
                'kwh' => $dataTagihan->total_kwh,
                'tagihan_kwh' => $dataTagihan->tagihan_kwh,
                'total_tagihan' => $dataTagihan->tagihan_kwh + $dataTagihan->tagihan_kios,
                'status_bayar' => $dataTagihan->MasterStatus->nama_status
            ];
        };

        if($response)
            return ResponseFormatter::success($response, 'Data Sewa Kios Berhasil di Ambil');
        else
            return ResponseFormatter::error(null, 'Data Sewa Kios Tidak Ada', 404);
    }
}
