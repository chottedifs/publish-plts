<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Fromview;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ReportTagihanExport implements Fromview, ShouldAutoSize
{
    public function view() : View
    {
        // $request1 = Request()->bulanTagihan;
        // ddd($request1);
        // $request = Request::input('bulanTagihan');
        // ddd($request);
        // if (!$request == NULL) {
        //     $bulan = $request;
        //     $bulanP = explode('-', $bulan);
        //     $roles = Auth::user()->roles;
        //     if ($roles == "plts") {
        //         $lokasiPlts = Auth::user()->Plts->lokasi_id;
        //         $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
        //         $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
        //         $dataTagihan = $dataBulan->where('lokasi_id', $lokasiPlts)->get();
        //     } elseif ($roles == "admin") {
        //         $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
        //         $dataTagihan = $dataTahun->whereMonth('periode', $bulanP[1])->get();
        //     }
        // } else {
        //     $bulan = Carbon::now()->format('Y-m');
        //     $bulanP = explode('-', $bulan);
        //     $roles = Auth::user()->roles;
        //     if ($roles == "plts") {
        //         $lokasiPlts = Auth::user()->Plts->lokasi_id;
        //         $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
        //         $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
        //         $dataTagihan = $dataBulan->where('lokasi_id', $lokasiPlts)->get();
        //     } elseif ($roles == "admin") {
        //         $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
        //         $dataTagihan = $dataTahun->whereMonth('periode', $bulanP[1])->get();
        //     }
        // }

        // return view('pages.admin.tagihan.table', [
        //     // 'dataTagihan' => $dataTagihan,
        // ]);

        return view('pages.admin.tagihan.index', [
            'dataTagihan' => Tagihan::all(),
        ]);
    }
}
