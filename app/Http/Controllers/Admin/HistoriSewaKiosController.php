<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SewaKios;
use App\Models\HistoriKios;
// use App\Models\SewaKios;
use Auth;

class HistoriSewaKiosController extends Controller
{
    public function index () {
        $roles = Auth::user()->roles;
        if ($roles == "operator") {
            $lokasiPetugas = Auth::user()->Petugas->lokasi_id;
            $historiKios = HistoriKios::with('SewaKios','Lokasi')->where('lokasi_id', $lokasiPetugas)->get();
        } elseif ($roles == "admin") {
            $historiKios = HistoriKios::with('SewaKios','Lokasi')->get();
        }

        return view('pages.admin.historiSewa.index',[
            'judul' => 'Histori Sewa Kios',
            'historiKios' => $historiKios
        ]);
    }
}
