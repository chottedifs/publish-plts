<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoriKios;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tagihan;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;

class HistoriTagihanController extends Controller
{
    public function index(Request $request)
    {
        $banyakLokasi = Lokasi::all();
        $roles = Auth::user()->roles;
        if ($roles == "operator"){
            $lokasi_id = Auth::user()->Petugas->lokasi_id;
            if ($request->bulanTagihan && $request->status_tagihan == 0 || $request->bulanTagihan && $request->status_tagihan == 1){
                // ddd("yyyyyy");
                $bulan = $request->bulanTagihan;
                $status_tagihan = $request->status_tagihan;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataStatus = $dataBulan->where('status_bayar', $status_tagihan);
                $dataTagihan = $dataStatus->where('lokasi_id', $lokasi_id)->get();
            } else {
                $bulan = Carbon::now()->format('Y-m');
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataTagihan = $dataBulan->where('lokasi_id', $lokasi_id)->get();
                // $dataTagihan = $dataStatus->where('lokasi_id', $roles);
            }
        } elseif ($roles == "admin") {
            if ($request->bulanTagihan && $request->status_tagihan == 0 || $request->bulanTagihan && $request->status_tagihan == 1){
                // ddd("yyyyyy");
                $bulan = $request->bulanTagihan;
                $status_tagihan = $request->status_tagihan;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataTagihan = $dataBulan->where('status_bayar', $status_tagihan)->get();
            } else {
                $bulan = Carbon::now()->format('Y-m');
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataTagihan = $dataTahun->whereMonth('periode', $bulanP[1])->get();
            }
        }


        return view('pages.admin.historiTagihan.index', [
            'judul' => 'Tagihan Penyewa Kios',
            'dataTagihan' => $dataTagihan,
            'periode' => $bulan,
            'banyakLokasi' =>$banyakLokasi
        ]);
    }

    public function isActive($id)
    {
        $histori = Tagihan::findOrFail($id);
        if ($histori->status_bayar == 1) {
            $active['status_bayar'] = 0;
            $histori->update($active);
            Alert::toast('Status Pembayaran Berhasil di Non-aktifkan!','success');
            return redirect(route('historiTagihan'));
        } elseif ($histori->status_sewa == 0) {
            $active['status_bayar'] = 1;
            // ddd($dataHistori);
            $histori->update($active);
            Alert::toast('Status Pembayaran Berhasil di Terbayar!','success');
            return redirect(route('historiTagihan'));
        }
    }
}
