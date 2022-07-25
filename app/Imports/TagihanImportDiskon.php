<?php

namespace App\Imports;

use App\Models\Tagihan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Str;

class TagihanImportDiskon implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Tagihan::where('kode_tagihan', $row['kode_tagihan'])->update([
                // 'kode_tagihan' => $kodeTagihan,
                // 'user_id' => $row['user_id'],
                // 'sewa_kios_id' => $row['sewa_id'],
                // 'lokasi_id' => $row['lokasi_id'],
                // 'total_kwh' => $row['total_kwh'],
                // 'tagihan_kwh' => $row['tarif_dasar_kwh'] * $row['total_kwh'],
                // 'tagihan_kios' => $row['tarif_kios'],
                // 'periode' => date('Y-m-d'),
                // 'status_id' => 1,
                'diskon' => $row['diskon'],
                'remarks' => $row['keterangan']
            ]);
        }
        // $kodeTagihan = $row['sewa_id'] . '-' . Str::random(5);
        // return new Tagihan([
        //     'kode_tagihan' => $kodeTagihan,
        //     'user_id' => $row['user_id'],
        //     'sewa_kios_id' => $row['sewa_id'],
        //     'lokasi_id' => $row['lokasi_id'],
        //     'total_kwh' => $row['total_kwh'],
        //     'tagihan_kwh' => $row['tarif_dasar_kwh'] * $row['total_kwh'],
        //     'tagihan_kios' => $row['tarif_kios'],
        //     'periode' => date('Y-m-d'),
        //     'status_id' => 1,
        //     'diskon' => 0
        // ]);
    }
}
