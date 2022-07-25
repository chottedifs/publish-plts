<?php

namespace App\Imports;

// use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Models\Pembayaran;
use App\Models\SewaKios;
use App\Models\Tagihan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Str;

class TagihanImport implements ToCollection, WithHeadingRow
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $periode = date('Y-m-d');
            $tahunAkhir = substr($periode, 2, 2);
            $bulanAkhir = substr($periode, 5, 2);
            $sewaKios = SewaKios::with('RelasiKios')->findOrFail($row['sewa_id']);
            $idKios = $sewaKios->RelasiKios->Kios->id;
            $usePlts = $sewaKios->RelasiKios->use_plts;
            if (strlen($idKios) < 2) {
                $noIdKantin = '0000' . $idKios;
            } elseif (strlen($idKios) < 3) {
                $noIdKantin = '000' . $idKios;
            } elseif (strlen($idKios) < 4) {
                $noIdKantin = '00' . $idKios;
            } elseif (strlen($idKios) < 5) {
                $noIdKantin = '0' . $idKios;
            } elseif (strlen($idKios) < 6) {
                $noIdKantin = $idKios;
            }
            $kodeTagihan = $tahunAkhir . $bulanAkhir . '10' . $usePlts . $noIdKantin;
            $tagihan = Tagihan::create([
                'kode_tagihan' => $kodeTagihan,
                'user_id' => $row['user_id'],
                'sewa_kios_id' => $row['sewa_id'],
                'lokasi_id' => $row['lokasi_id'],
                'total_kwh' => $row['total_kwh'],
                'tagihan_kwh' => $row['tarif_dasar_kwh'] * $row['total_kwh'],
                'tagihan_kios' => $row['tarif_kios'],
                'periode' => date('Y-m-d'),
                'master_status_id' => 1,
                'diskon' => 0
            ]);

            Pembayaran::create([
                'tagihan_id' => $tagihan->id,
                'kode_tagihan' => $tagihan->kode_tagihan,
                'periode' => $tagihan->periode,
                'lokasi_id' => $tagihan->lokasi_id,
                'master_status_id' => $tagihan->master_status_id
            ]);
        }
        $this->_tagihanPln();
    }

    private function _tagihanPln()
    {
        $periode = date('Y-m-d');
        $tahunAkhir = substr($periode, 2, 2);
        $bulanAkhir = substr($periode, 5, 2);
        $sewaKiosPln = SewaKios::with('RelasiKios', 'User', 'Lokasi')->where(['status_sewa' => 1, 'use_plts' => 0])->get();
        $banyakData = count($sewaKiosPln);
        for ($i = 0; $i < $banyakData; $i++) {
            $idKios = $sewaKiosPln[$i]->RelasiKios->Kios->id;
            $usePlts = $sewaKiosPln[$i]->RelasiKios->use_plts;
            if (strlen($idKios) < 2) {
                $noIdKantin = '0000' . $idKios;
            } elseif (strlen($idKios) < 3) {
                $noIdKantin = '000' . $idKios;
            } elseif (strlen($idKios) < 4) {
                $noIdKantin = '00' . $idKios;
            } elseif (strlen($idKios) < 5) {
                $noIdKantin = '0' . $idKios;
            } elseif (strlen($idKios) < 6) {
                $noIdKantin = $idKios;
            }
            $kodeTagihan = $tahunAkhir . $bulanAkhir . '10' . $usePlts . $noIdKantin;
            $tagihan = Tagihan::create([
                'kode_tagihan' => $kodeTagihan,
                'user_id' => $sewaKiosPln[$i]->User->id,
                'sewa_kios_id' => $sewaKiosPln[$i]->id,
                'lokasi_id' => $sewaKiosPln[$i]->lokasi->id,
                'total_kwh' => 0,
                'tagihan_kwh' => 0,
                'tagihan_kios' => $sewaKiosPln[$i]->RelasiKios->TarifKios->harga,
                'periode' => date('Y-m-d'),
                'master_status_id' => 1,
                'diskon' => 0
            ]);

            Pembayaran::create([
                'tagihan_id' => $tagihan->id,
                'kode_tagihan' => $tagihan->kode_tagihan,
                'periode' => $tagihan->periode,
                'lokasi_id' => $tagihan->lokasi_id,
                'master_status_id' => $tagihan->master_status_id
            ]);
        }
    }
}
