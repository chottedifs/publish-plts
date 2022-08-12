<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Tagihan;
use App\Models\Lokasi;
use App\Exports\TagihanExport;
use App\Exports\TagihanExportDiskon;
use App\Exports\ReportTagihanExport;
use App\Exports\ReportExcelTagihan;
use App\Imports\TagihanImport;
use App\Imports\TagihanImportDiskon;
use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Protection;
use PDF;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $banyakLokasi = Lokasi::all();
        $roles = Auth::user()->roles;
        // if ($roles == "plts") {
        if ($roles == 'operator') {
            $petugas = Petugas::where('login_id', Auth::user()->id)->get();
            $lokasiId = $petugas[0]->lokasi_id;
            if ($request->bulanTagihan && $request->lokasi) {
                $bulan = $request->bulanTagihan;
                $lokasi = $lokasiId;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataTagihan = $dataBulan->where('lokasi_id', $lokasi)->get();
            } elseif ($request->lokasi) {
                $bulan = Carbon::now()->format('Y-m');
                $lokasi = $lokasiId;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataTagihan = $dataBulan->where('lokasi_id', $lokasi)->get();
            } else {
                $bulan = Carbon::now()->format('Y-m');
                $bulanP = explode('-', $bulan);
                $lokasi = $lokasiId;
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataTagihan = $dataBulan->where('lokasi_id', $lokasi)->get();
            }
        } elseif ($roles == 'admin' || $roles == 'plts') {
            if ($request->bulanTagihan && $request->lokasi) {
                $bulan = $request->bulanTagihan;
                $lokasi = $request->lokasi;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataTagihan = $dataBulan->where('lokasi_id', $lokasi)->get();
            } elseif ($request->lokasi) {
                $bulan = Carbon::now()->format('Y-m');
                $lokasi = $request->lokasi;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
                $dataTagihan = $dataBulan->where('lokasi_id', $lokasi)->get();
            } elseif ($request->bulanTagihan) {
                $bulan = $request->bulanTagihan;
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataTagihan = $dataTahun->whereMonth('periode', $bulanP[1])->get();
            } else {
                $bulan = Carbon::now()->format('Y-m');
                $bulanP = explode('-', $bulan);
                $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
                $dataTagihan = $dataTahun->whereMonth('periode', $bulanP[1])->get();
            }
        }

        // }
        if ($roles == 'admin' || $roles == 'plts') {
            return view('pages.admin.tagihan.index', [
                'judul' => 'Tagihan Penyewa Kios',
                'dataTagihan' => $dataTagihan,
                'periode' => $bulan,
                'banyakLokasi' => $banyakLokasi,
            ]);
        } elseif ($roles == 'operator') {
            $petugas = Petugas::where('login_id', Auth::user()->id)->get();
            return view('pages.admin.tagihan.index', [
                'judul' => 'Tagihan Penyewa Kios',
                'dataTagihan' => $dataTagihan,
                'periode' => $bulan,
                'banyakLokasi' => $banyakLokasi,
                'lokasi_id' => $petugas[0]->lokasi_id
            ]);
        }
    }

    public function create()
    {
        $this->authorize('plts');
        return Excel::download(new TagihanExport, 'template-tagihan' . time() . '.xlsx');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $tagihan = Tagihan::with('SewaKios', 'Lokasi')->findOrFail($id);
        return view('pages.admin.tagihan.edit', [
            'judul' => 'Edit Tagihan Penyewa Kios',
            'tagihan' => $tagihan,
        ]);
    }

    public function update(Request $request, $id)
    {
        $tagihan = Tagihan::with('SewaKios', 'Lokasi')->findOrFail($id);
        $validatedData = $request->validate([
            'total_kwh' => 'required|numeric'
        ]);
        $tagihan->update($validatedData);
        Alert::toast('Data Berhasil Di Update!', 'success');
        return redirect(route('tagihan-index'));
    }

    public function destroy($id)
    {
        //
    }

    public function import(Request $request)
    {
        $this->authorize('plts');
        $file = $request->file('import-file');

        $namaFile = $file->getClientOriginalName();

        $file->move('uploads-tagihan-kwh', $namaFile);

        $import = Excel::import(new TagihanImport, public_path('/uploads-tagihan-kwh/' . $namaFile));

        if ($import) {
            Alert::toast('Data berhasil diimport!', 'success');
            return redirect(route('tagihan-index'));
        } else {
            //redirect
            Alert::toast('Data gagal diimport!', 'warning');
            return redirect(route('tagihan-index'));
        }
    }

    public function createDiskon($bulanTagihan, $lokasiTagihan)
    {
        if ($lokasiTagihan != 0) {
            $bulan = $bulanTagihan;
            $lokasi = $lokasiTagihan;
            $bulanP = explode('-', $bulan);
            $dataTahun = Tagihan::with('SewaKios')->whereYear('periode', $bulanP[0]);
            $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
            $dataTagihan = $dataBulan->where([
                'lokasi_id' => $lokasi,
                'master_status_id' => 1
            ])->get();
        } else {
            $bulan = $bulanTagihan;
            $bulanP = explode('-', $bulan);
            $dataTahun = Tagihan::with('SewaKios')->whereYear('periode', $bulanP[0]);
            $dataTagihan = $dataTahun->whereMonth('periode', $bulanP[1])->get();
        }

        return Excel::download(new TagihanExportDiskon($dataTagihan), 'template-tagihan-diskon' . time() . '.xlsx');
    }

    public function importDiskon(Request $request)
    {
        $file = $request->file('import-file');

        $namaFile = $file->getClientOriginalName();

        $file->move('uploads-tagihan-diskon', $namaFile);

        // import data
        $data = Tagihan::all()->last();
        $dataPeriode = $data->periode;
        $bulanP = explode('-', $dataPeriode);
        $dataTagihan = Tagihan::with('SewaKios')->where('master_status_id', 1)->whereMonth('periode', $bulanP[1])->orWhere('master_status_id', 4)->get();

        if ($dataTagihan) {
            Excel::import(new TagihanImportDiskon, public_path('/uploads-tagihan-diskon/' . $namaFile));
            Alert::toast('Data berhasil diimport!', 'success');
            return redirect(route('tagihan-index'));
        } else {
            //redirect
            Alert::toast('Data gagal diimport!', 'warning');
            return redirect(route('tagihan-index'));
        }
    }

    public function editDiskon($id)
    {
        $tagihan = Tagihan::with('SewaKios', 'Lokasi')->findOrFail($id);
        return view('pages.admin.tagihan.editDiskon', [
            'judul' => 'Edit Tagihan Diskon Penyewa Kios',
            'tagihan' => $tagihan,
        ]);
    }

    public function updateDiskon(Request $request, $id)
    {
        $tagihan = Tagihan::with('SewaKios', 'Lokasi')->findOrFail($id);
        $validatedData = $request->validate([
            'diskon' => 'required|numeric',
            'remarks' => 'required'
        ]);
        $tagihan->update($validatedData);
        Alert::toast('Data Tagihan Diskon Berhasil Di Update!', 'success');
        return redirect(route('tagihan-index'));
    }

    public function reportTagihan($bulanTagihan, $lokasiTagihan)
    {
        if ($lokasiTagihan != 0) {
            $bulan = $bulanTagihan;
            $lokasi = $lokasiTagihan;
            $bulanP = explode('-', $bulan);
            $dataTahun = Tagihan::with('SewaKios')->whereYear('periode', $bulanP[0]);
            $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
            $dataTagihan = $dataBulan->where('lokasi_id', $lokasi)->get();
        } else {
            $bulan = $bulanTagihan;
            $lokasi = $lokasiTagihan;
            $bulanP = explode('-', $bulan);
            $dataTahun = Tagihan::with('SewaKios')->whereYear('periode', $bulanP[0]);
            $dataTagihan = $dataTahun->whereMonth('periode', $bulanP[1])->get();
        }
        // $roles = Auth::user()->roles;
        // if ($roles == "operator") {
        //     $lokasiPetugas = Auth::user()->Petugas->lokasi_id;
        //     $dataTagihan = Tagihan::with('SewaKios')->where('lokasi_id', $lokasiPetugas)->whereMonth('periode', date('m'))->get();
        // } elseif ($roles == "admin") {
        //     $lokasiPetugas = 'Yayasan Sasmita Jaya';
        //     $dataTagihan = Tagihan::with('SewaKios')->whereMonth('periode', date('m'))->get();
        // }

        $pdf = PDF::loadview('pages.admin.tagihan.cetakTagihan', [
            'dataTagihan' => $dataTagihan,
            'lokasi' => $lokasi,
            'bulan' => $bulan
        ]);
        return $pdf->stream();
    }

    public function reportExcelTagihan($bulanTagihan, $lokasiTagihan)
    {
        if ($lokasiTagihan != 0) {
            $bulan = $bulanTagihan;
            $lokasi = $lokasiTagihan;
            $bulanP = explode('-', $bulan);
            $dataTahun = Tagihan::with('SewaKios')->whereYear('periode', $bulanP[0]);
            $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
            $dataTagihan = $dataBulan->where('lokasi_id', $lokasi)->get();
        } else {
            $bulan = $bulanTagihan;
            $bulanP = explode('-', $bulan);
            $dataTahun = Tagihan::with('SewaKios')->whereYear('periode', $bulanP[0]);
            $dataTagihan = $dataTahun->whereMonth('periode', $bulanP[1])->get();
        }
        return Excel::download(new ReportExcelTagihan($dataTagihan), 'laporan-tagihan-' . time() . '.xlsx');
    }
}
