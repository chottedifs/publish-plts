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
        // $roles = Auth::user()->roles;
        // if ($roles == "plts") {
        if ($request->bulanTagihan && $request->lokasi) {
            $bulan = $request->bulanTagihan;
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
        } elseif ($request->lokasi) {
            // $bulan = $request->bulanTagihan;
            $bulan = Carbon::now()->format('Y-m');
            $lokasi = $request->lokasi;
            $bulanP = explode('-', $bulan);
            $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
            $dataBulan = $dataTahun->whereMonth('periode', $bulanP[1]);
            $dataTagihan = $dataBulan->where('lokasi_id', $lokasi)->get();
        } else {
            $bulan = Carbon::now()->format('Y-m');
            $bulanP = explode('-', $bulan);
            $dataTahun = Tagihan::whereYear('periode', $bulanP[0]);
            $dataTagihan = $dataTahun->whereMonth('periode', $bulanP[1])->get();
        }
        // }
        return view('pages.admin.tagihan.index', [
            'judul' => 'Tagihan Penyewa Kios',
            'dataTagihan' => $dataTagihan,
            'periode' => $bulan,
            'banyakLokasi' => $banyakLokasi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('plts');
        // $sheet->setCell('B')->setHidden();
        return Excel::download(new TagihanExport, 'template-tagihan' . time() . '.xlsx');
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
        $tagihan = Tagihan::with('SewaKios', 'Lokasi')->findOrFail($id);
        return view('pages.admin.tagihan.edit', [
            'judul' => 'Edit Tagihan Penyewa Kios',
            'tagihan' => $tagihan,
        ]);
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
        $tagihan = Tagihan::with('SewaKios', 'Lokasi')->findOrFail($id);
        $validatedData = $request->validate([
            'total_kwh' => 'required|numeric'
        ]);
        $tagihan->update($validatedData);
        Alert::toast('Data Berhasil Di Update!', 'success');
        return redirect(route('tagihan-index'));
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

    public function import(Request $request)
    {
        $this->authorize('plts');
        $file = $request->file('import-file');

        $namaFile = $file->getClientOriginalName();

        $file->move('uploads-tagihan-kwh', $namaFile);

        // import data
        $import = Excel::import(new TagihanImport, public_path('/uploads-tagihan-kwh/' . $namaFile));

        if ($import) {
            // $tagihanPeriode = Tagihan::all()->last();

            // ddd($tagihanPeriode->periode);
            // $pembayaran = new Pembayaran;
            // $data = count($tagihanPeriode);
            // for ($i = 0; $i < $data; $i++) {
            //     $dataa[] = $tagihanPeriode[$i]->kode_tagihan;
            // }

            //redirect
            Alert::toast('Data berhasil diimport!', 'success');
            return redirect(route('tagihan-index'));
        } else {
            //redirect
            Alert::toast('Data gagal diimport!', 'warning');
            return redirect(route('tagihan-index'));
        }
    }

    public function createDiskon()
    {
        return Excel::download(new TagihanExportDiskon, 'template-tagihan-diskon' . time() . '.xlsx');
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
            // $dataTagihan->update();
            Excel::import(new TagihanImportDiskon, public_path('/uploads-tagihan-diskon/' . $namaFile));
            // $tagihanPeriode = Tagihan::all()->last();

            // ddd($tagihanPeriode->periode);
            // $pembayaran = new Pembayaran;
            // $data = count($tagihanPeriode);
            // for ($i = 0; $i < $data; $i++) {
            //     $dataa[] = $tagihanPeriode[$i]->kode_tagihan;
            // }

            //redirect
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

    public function reportTagihan()
    {
        $roles = Auth::user()->roles;
        if ($roles == "operator") {
            $lokasiPetugas = Auth::user()->Petugas->lokasi_id;
            $dataTagihan = Tagihan::with('SewaKios')->where('lokasi_id', $lokasiPetugas)->whereMonth('periode', date('m'))->get();
        } elseif ($roles == "admin") {
            $lokasiPetugas = 'Yayasan Sasmita Jaya';
            $dataTagihan = Tagihan::with('SewaKios')->whereMonth('periode', date('m'))->get();
        }

        $pdf = PDF::loadview('pages.admin.tagihan.cetakTagihan',[
            'dataTagihan' => $dataTagihan,
            'lokasi' => $lokasiPetugas
        ]);
    	return $pdf->stream();
    }

    public function reportExcelTagihan()
    {
        return Excel::download(new ReportExcelTagihan, 'laporan-tagihan-' . time() . '.xlsx');
    }
}
