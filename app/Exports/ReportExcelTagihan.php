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

    protected $dataTagihan;
    public function __construct($tagihan)
    {
        $this->dataTagihan = $tagihan;
    }

    public function collection()
    {
        return $this->dataTagihan;
    }

    public function map($dataTagihan): array
    {
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
