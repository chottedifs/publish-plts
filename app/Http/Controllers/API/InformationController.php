<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;

class InformationController extends Controller
{
    public function all(Request $request){
        $informations = Informasi::all();

        if($informations)
            return ResponseFormatter::success($informations, 'Data Sewa Kios Berhasil di Ambil');
        else
            return ResponseFormatter::error(null, 'Data Sewa Kios Tidak Ada', 404);
    }
}
