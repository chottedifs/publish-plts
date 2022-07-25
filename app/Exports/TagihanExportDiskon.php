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

class TagihanExportDiskon implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents, WithStyles
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
        $tarif_dasar = TarifKwh::select('harga')->first();
        $tanggal = date('M Y');

        // ddd($tarif_dasar);
        return [
            $dataTagihan->SewaKios->RelasiKios->Kios->nama_kios,
            $dataTagihan->user_id,
            $dataTagihan->sewa_kios_id,
            $dataTagihan->lokasi_id,
            $dataTagihan->total_kwh,
            $dataTagihan->tagihan_kwh,
            $dataTagihan->tagihan_kios,
            $dataTagihan->master_status_id,
            $dataTagihan->kode_tagihan,
            $dataTagihan->SewaKios->User->nama_lengkap,
            date('M Y', strtotime($dataTagihan->periode)),
            $dataTagihan->diskon,
            $dataTagihan->remarks,
        ];
    }

    public function headings(): array
    {
        return [
            ' ',
            'user_id',
            'sewa_kios_id',
            'lokasi_id',
            'total_kwh',
            'tagihan_kwh',
            'tagihan_kios',
            'master_status_id',
            'kode_tagihan',
            'nama_penyewa',
            'periode',
            'diskon',
            'keterangan'
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

    public static function afterSheet(AfterSheet $event)
    {
        try {
            // Inisialisasi semua column untuk dilock
            $workSheet = $event
                ->sheet
                ->getProtection()
                ->setSheet(true);

            // // Hide Column yang tidak diperlukan
            $workSheet = $event->sheet->getColumnDimension('B')->setVisible(false);
            $workSheet = $event->sheet->getColumnDimension('C')->setVisible(false);
            $workSheet = $event->sheet->getColumnDimension('D')->setVisible(false);
            $workSheet = $event->sheet->getColumnDimension('E')->setVisible(false);
            $workSheet = $event->sheet->getColumnDimension('F')->setVisible(false);
            $workSheet = $event->sheet->getColumnDimension('G')->setVisible(false);
            $workSheet = $event->sheet->getColumnDimension('H')->setVisible(false);

            // Unlock Column untuk diisi
            $workSheet = $event
                ->sheet
                ->getStyle('L')
                ->getProtection()
                ->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);

            // Unlock Column untuk diisi
            $workSheet = $event
                ->sheet
                ->getStyle('M')
                ->getProtection()
                ->setLocked(\PhpOffice\PhpSpreadsheet\Style\Protection::PROTECTION_UNPROTECTED);
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}
