<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sewakios;
use App\Models\Relasikios;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class KiosController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');

        if($id){
            $sewaKios = SewaKios::where('relasi_kios_id', $user->id);
            $kios = RelasiKios::with('Kios')->where('id', $sewaKios->id)->get();
            // $kios = RelasiKios::with('Kios')->where('id', $sewaKios[0]->relasi_kios_id)->get();

            if($kios)
                return ResponseFormatter::success($kios, 'Data Sewa Kios Berhasil di Ambil');
            else
                return ResponseFormatter::error(null, 'Data Sewa Kios Tidak Ada', 404);
        }
    }
}
