<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoriKios;
use App\Models\Lokasi;
use App\Models\Pembayaran;
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
        if ($roles == "operator") {
            $lokasi_id = Auth::user()->Petugas->lokasi_id;
            if ($request->bulanTagihan && $request->status_tagihan) {
                $bulan = $request->bulanTagihan;
                $status_tagihan = $request->status_tagihan;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataStatus = $dataBulan->where('master_status_id', $status_tagihan);
                $dataTagihan = $dataStatus->where('lokasi_id', $lokasi_id)->get();
            } elseif ($request->bulanTagihan) {
                $bulan = $request->bulanTagihan;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataTagihan = $dataBulan->where('lokasi_id', $lokasi_id)->get();
            } elseif ($request->status_tagihan) {
                $bulan = Carbon::now()->format('Y-m');
                $status_tagihan = $request->status_tagihan;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataStatus = $dataBulan->where('master_status_id', $status_tagihan);
                $dataTagihan = $dataStatus->where('lokasi_id', $lokasi_id)->get();
            } else {
                $bulan = Carbon::now()->format('Y-m');
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataTagihan = $dataBulan->where('lokasi_id', $lokasi_id)->get();
            }
        } elseif ($roles == "admin") {
            if ($request->bulanTagihan && $request->status_tagihan) {
                $bulan = $request->bulanTagihan;
                $status_tagihan = $request->status_tagihan;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataTagihan = $dataBulan->where('master_status_id', $status_tagihan)->get();
            } elseif ($request->bulanTagihan) {
                $bulan = $request->bulanTagihan;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataTagihan = $dataTahun->whereMonth('periode', $bulanP[1])->get();
            } elseif ($request->status_tagihan) {
                $bulan = Carbon::now()->format('Y-m');
                $status_tagihan = $request->status_tagihan;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataTagihan = $dataBulan->where('master_status_id', $status_tagihan)->get();
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
            'banyakLokasi' => $banyakLokasi
        ]);
    }

    public function StatusPembayaran($id)
    {
        $histori = Tagihan::findOrFail($id);
        $pembayaran = Pembayaran::where('tagihan_id', $histori->id)->first();

        if ($histori->master_status_id == 1) {
            $stsPembayaran['master_status_id'] = 3;
            $status_pembayaran['master_status_id'] = 3;
            $pembayaran->update($status_pembayaran);
            $histori->update($stsPembayaran);
            Alert::toast('Status Pembayaran Menjadi Terbayar!', 'success');
            return redirect(route('historiTagihan'));
        } elseif ($histori->master_status_id == 3) {
            $stsPembayaran['master_status_id'] = 1;
            $histori->update($stsPembayaran);
            $status_pembayaran['master_status_id'] = 1;
            $pembayaran->update($status_pembayaran);
            Alert::toast('Status Pembayaran Menjadi Belum Terbayar!', 'success');
            return redirect(route('historiTagihan'));
        }
    }
}
