<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\Login;
use App\Models\SewaKios;
use App\Models\RelasiKios;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;
// use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $login = Auth::user();
        $users = User::where('login_id', $login->id)->get();
        $sewaKios = SewaKios::with('Tagihan', 'User', 'RelasiKios')->where('user_id', $users[0]->id)->get();
        $jumlahSewa = count($sewaKios);
        if ($sewaKios != null) {
            for ($i = 0; $i < $jumlahSewa; $i++) {
                // $data = [];
                $data[] = response()->json([
                    'message' => 'sukses',
                    'nama' => $sewaKios[$i]->User->nama_lengkap,
                    'nama_kios' => $sewaKios[$i]->RelasiKios->Kios->nama_kios,
                    'tagihan_kwh' => $sewaKios[$i]->Tagihan->tagihan_kwh,
                    'total_kwh' => $sewaKios[$i]->Tagihan->total_kwh,
                    'periode' => $sewaKios[$i]->Tagihan->periode,
                ], 200);
            }
            $informasi = Informasi::all();
            $data[] = response()->json([
                'informasi' => $informasi
            ]);
            return $data;
        } else {
            return response()->json([
                'message' => 'gagal data tidak ada'
            ]);
        }
    }

    public function tagihan()
    {
        $login = Auth::user();
        $users = User::where('login_id', $login->id)->get();
        $tagihan = SewaKios::with('Tagihan')->where('user_id', $users[0]->id)->get();
        $jumlahSewa = count($tagihan);
        if ($tagihan != null) {
            for ($i = 0; $i < $jumlahSewa; $i++) {
                $data[] = response()->json([
                    'message' => 'sukses',
                    'id' => $tagihan[$i]->Tagihan->id,
                    'status' => $tagihan[$i]->Tagihan->status_bayar,
                    'tagihan_kwh' => $tagihan[$i]->Tagihan->tagihan_kwh,
                    'total_kwh' => $tagihan[$i]->Tagihan->total_kwh,
                    'periode' => $tagihan[$i]->Tagihan->periode,
                ], 200);
            }
            return $data;
        } else {
            return response()->json([
                'message' => 'gagal data tidak ada'
            ]);
        }
    }

    public function detailKios()
    {
        $login = Auth::user();
        $users = User::where('login_id', $login->id)->get();
        $kios = SewaKios::with('RelasiKios')->where('user_id', $users[0]->id)->get();
        $jumlahSewa = count($kios);
        if ($kios != null) {
            for ($i = 0; $i < $jumlahSewa; $i++) {
                $data[] = response()->json([
                    'message' => 'sukses',
                    'nama_kios' => $kios[$i]->RelasiKios->Kios->nama_kios,
                    'luas_kios' => $kios[$i]->RelasiKIos->Kios->luas_kios,
                    'tagihan_kios' => $kios[$i]->RelasiKios->TarifKios->harga,
                    'tipe_tarif' => $kios[$i]->RelasiKios->TarifKios->tipe,
                    'lokasi' => $kios[$i]->RelasiKios->Lokasi->nama_lokasi,
                ], 200);
            }
            return $data;
        } else {
            return response()->json([
                'message' => 'gagal data tidak ada'
            ]);
        }
    }

    public function userKios()
    {
        $login = Auth::user();
        $users = User::where('login_id', $login->id)->get();
        // $jumlahSewa = count($users);
        if ($users != null) {
            // for ($i = 0; $i < $jumlahSewa; $i++) {
            $data[] = response()->json([
                'message' => 'sukses',
                'email' => $users[0]->Login->email,
                'nama_penyewa' => $users[0]->nama_lengkap,
                'no_telp' => $users[0]->no_hp,
                'nik' => $users[0]->nik,
                'rekening' => $users[0]->rekening,
            ], 200);
            // }
            return $data;
        } else {
            return response()->json([
                'message' => 'gagal data tidak ada'
            ]);
        }
    }

    public function detailInformasi($id)
    {
        // $login = Auth::user();
        // $users = User::where('login_id', $login->id)->get();
        $informasi = Informasi::findOrFail($id);
        // $jumlahSewa = count($users);
        if ($informasi != null) {
            // for ($i = 0; $i < $jumlahSewa; $i++) {
            $data[] = response()->json([
                'message' => 'sukses',
                'title' => $informasi->title,
                'deskripsi' => $informasi->deskripsi,
                'gambar' => $informasi->gambar,
            ], 200);
            // }
            return $data;
        } else {
            return response()->json([
                'message' => 'gagal data tidak ada'
            ]);
        }
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
