<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Lokasi;
use App\Models\Pembayaran;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Carbon\Carbon;
use
    Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userLogin = Auth::user();
        if ($userLogin->roles == "operator") {
            $userRole = Petugas::where('login_id', $userLogin->id)->get();
            $pembayarans = Pembayaran::where('lokasi_id', $userRole[0]->lokasi_id)->get();
            // $pembayarans = Pembayaran::where();
        } elseif ($userLogin->roles == "admin") {
            $pembayarans = Pembayaran::all();
        }

        $banyakLokasi = Lokasi::all();
        $bulan = Carbon::now()->format('Y-m');
        return view('pages.admin.pembayaran.index', [
            'judul' => 'Data Pembayaran',
            'periode' => $bulan,
            'banyakLokasi' => $banyakLokasi,
            'pembayarans' => $pembayarans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
