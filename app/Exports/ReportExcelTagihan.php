<?php

namespace App\Exports;

use App\Models\SewaKios;
use App\Models\User;
use App\Models\TarifKwh;
use App\Models\Petugas;
use App\Models\Tagihan;
use Exception;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExcelTagihan implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents, WithStyles
{
    use RegistersEventListeners;

    public function collection()
    {
        $login = Auth::user();
        $data = Tagihan::all()->last();
        $dataPeriode = $data->periode;
        $bulanP = explode('-', $dataPeriode);
        if ($login->roles == "admin") {
            // ddd($dataPeriode);
            // ddd($bulanP[1]);
            $dataTagihan = Tagihan::with('SewaKios')->where('master_status_id', 1)->whereMonth('periode', $bulanP[1])->orWhere('master_status_id', 4)->get();
            // $lokasiPlts = Auth::user()->Plts->lokasi_id;
            // // $lokasiKios = RelasiKios::with('Lokasi')->where('lokasi_id', $lokasiPlts)->get();
            // $tagihan = tagihan::with('RelasiKios')->where([
            //     'lokasi_id' => $lokasiPlts,
            //     'status_sewa' => 1
            //     ])->get();
            // // $tagihan = tagihan::with('RelasiKios')->get();
        } elseif ($login->roles == "operator") {
            $petugas = Petugas::where('login_id', $login->id)->get();
            // $tagihan = Tagihan::with('RelasiKios', 'User')->where(['status_sewa' => 1, 'lokasi_id' => $petugas[0]->lokasi_id])->get();
            $dataTagihan = Tagihan::with('SewaKios')->where([
                'master_status_id' => 1,
                'lokasi_id' => $petugas[0]->lokasi_id
            ])->whereMonth('periode', $bulanP[1])->orWhere('master_status_id', 4)->get();
        }
        // elseif ($roles == "admin") {
        //     $tagihan = tagihan::with('RelasiKios')->where('status_sewa', 1)->get();
        // }

        return $dataTagihan;
    }

    public function map($dataTagihan): array
    {
        // $tarif_dasar = TarifKwh::select('harga')->first();
        // $tanggal = date('M Y');

        // ddd($tarif_dasar);
        return [
            $dataTagihan->kode_tagihan,
            $dataTagihan->SewaKios->User->nama_lengkap,
            $dataTagihan->SewaKios->RelasiKios->Kios->nama_kios,
            $dataTagihan->SewaKios->RelasiKios->Lokasi->nama_lokasi,
            $dataTagihan->total_kwh,
            $dataTagihan->tagihan_kwh,
            $dataTagihan->tagihan_kios,
            $dataTagihan->diskon,
            $dataTagihan->tagihan_kwh + $dataTagihan->tagihan_kios,
            $dataTagihan->periode,
            $dataTagihan->keterangan
        ];
    }

    public function headings(): array
    {
        return [
            'Kode Tagihan',
            'Nama Penyewa',
            'Kios',
            'Lokasi Kios',
            'Kwh Terpakai',
            'Tagihan Kwh',
            'Tagihan Kios',
            'Diskon',
            'Total Tagihan',
            'Periode',
            'Keterangan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => [
                'bold' => true,
                'size' => 13
            ]],
        ];
    }
}
