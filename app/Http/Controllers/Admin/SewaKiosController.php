<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use
    App\Models\RelasiKios;
use App\Models\SewaKios;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class sewaKiosController extends Controller
{
    public function index()
    {
        $roles = Auth::user()->roles;
        if ($roles == "operator") {
            $lokasiPetugas = Auth::user()->Petugas->lokasi_id;
            $sewaKios = SewaKios::with('RelasiKios')->where('lokasi_id', $lokasiPetugas)->get();
        } elseif ($roles == "admin") {
            $sewaKios = SewaKios::with('RelasiKios')->get();
        }

        return view('pages.admin.sewaKios.index', [
            'judul' => 'Data Sewa Kios',
            'sewaKios' => $sewaKios,
        ]);
    }

    public function create()
    {

        $roles = Auth::user()->roles;
        if ($roles == "operator") {
            $lokasiPetugas = Auth::user()->Petugas->lokasi_id;
            $user = User::with('Lokasi')->where('lokasi_id', $lokasiPetugas)->get();
            $relasiKios = RelasiKios::with('Kios', 'Lokasi')->where('lokasi_id', $lokasiPetugas)->get();
        } elseif ($roles == "admin") {
            $user = User::all();
            $relasiKios = RelasiKios::with('Kios')->get();
        }

        return view('pages.admin.sewaKios.create', [
            'judul' => 'Sewa Kios',
            'relasiDataKios' => $relasiKios,
            'users' => $user
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'relasi_kios_id' => 'required',
            'tgl_sewa' => 'required'
        ]);
        $statusRelasiKios = RelasiKios::findOrFail($validatedData['relasi_kios_id']);

        $validatedData['status_sewa'] = true;
        $validatedData['use_plts'] = $statusRelasiKios->use_plts;
        $validatedData['lokasi_id'] = $statusRelasiKios['lokasi_id'];
        $sewa = SewaKios::create($validatedData);

        $statusRelasiKios['status_relasi_kios'] = true;
        $statusRelasiKios->update();

        Alert::toast('Data penyewa kios berhasil ditambahkan!', 'success');
        return redirect(route('sewa-kios.index'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $sewaKios = SewaKios::findOrFail($id);
        $roles = Auth::user()->roles;
        if ($roles == "operator") {
            $lokasiPetugas = Auth::user()->Petugas->lokasi_id;
            $user = User::with('Lokasi')->where('lokasi_id', $lokasiPetugas)->get();
            $relasiKios = RelasiKios::with('Kios', 'Lokasi')->where('lokasi_id', $lokasiPetugas)->get();
        } elseif ($roles == "admin") {
            $user = User::all();
            $relasiKios = RelasiKios::with('Kios')->get();
        }

        return view('pages.admin.sewaKios.edit', [
            'judul' => 'Edit Data Sewa Kios',
            'sewaKios' => $sewaKios,
            'users' => $user,
            'relasiKios' => $relasiKios,
        ]);
    }

    public function update(Request $request, $id)
    {
        $sewaKios = SewaKios::with('RelasiKios', 'Tagihan')->where('id', $id)->get();

        // Validasi Input
        $validatedData = $request->validate([
            'user_id' => 'required',
            'relasi_kios_id' => 'required',
        ]);

        $statusRelasiKios = RelasiKios::findOrFail($validatedData['relasi_kios_id']);
        if ($validatedData['user_id'] != $sewaKios[0]->user_id) {
            if ($validatedData['relasi_kios_id'] != $sewaKios[0]->relasi_kios_id) {
                //? jika user dan kios berubah
                $validatedData = $request->validate([
                    'user_id' => 'required',
                    'relasi_kios_id' => 'required'
                ]);
                // $relasiKios = RelasiKios::findOrFail()
                //? mengisi tgl akhir sewa dan status sewanya menjadi false
                $sewaSebelumnya['tgl_akhir_sewa'] = date('Y-m-d');
                $sewaSebelumnya['status_sewa'] = false;
                $sewaKios[0]->update($sewaSebelumnya);
                //? membuat status relasi kios sebelumnya menjadi false
                $relasiKiosSebelumnya['status_relasi_kios'] = false;
                $sewaKios[0]->RelasiKios->update($relasiKiosSebelumnya);
                //? membuat data baru dengan user yg berbeda dan kios yg berbeda
                $statusRelasiKios['status_relasi_kios'] = true;
                $statusRelasiKios->update();
                $validatedData['tgl_sewa'] = Carbon::now()->format('Y-m-d');
                $validatedData['status_sewa'] = true;
                $validatedData['lokasi_id'] = $statusRelasiKios['lokasi_id'];
                SewaKios::create($validatedData);
                Alert::toast('Data penyewa User Dan Kios berhasil Di Update!', 'success');
                return redirect(route('sewa-kios.index'));
            } else {
                //? jika user berbeda dan relasi kios nya tetap sama
                $validatedData = $request->validate([
                    'user_id' => 'required',
                    'relasi_kios_id' => 'required',
                ]);
                //? mengubah status sewa sebelumnya
                $sewaSebelumnya['tgl_akhir_sewa'] = date('Y-m-d');
                $sewaSebelumnya['status_sewa'] = false;
                $sewaKios[0]->update($sewaSebelumnya);
                //? membuat data sewa yg baru
                $validatedData['tgl_sewa'] = Carbon::now()->format('Y-m-d');
                $validatedData['status_sewa'] = true;
                $validatedData['lokasi_id'] = $statusRelasiKios['lokasi_id'];
                SewaKios::create($validatedData);
                Alert::toast('Data penyewa User berhasil Di Update!', 'success');
                return redirect(route('sewa-kios.index'));
            }
        } elseif ($validatedData['relasi_kios_id'] != $sewaKios[0]->relasi_kios_id) {
            //? jika usernya sama tapi relasi kios nya berbeda
            $validatedData = $request->validate([
                'user_id' => 'required',
                'relasi_kios_id' => 'required'
            ]);
            //? mengubah status sewa sebelumnya
            $sewaSebelumnya['tgl_akhir_sewa'] = date('Y-m-d');
            $sewaSebelumnya['status_sewa'] = false;
            $sewaKios[0]->update($sewaSebelumnya);
            //? membuat status relasi kios sebelumnya menjadi false
            $relasiKiosSebelumnya['status_relasi_kios'] = false;
            $sewaKios[0]->RelasiKios->update($relasiKiosSebelumnya);
            //? membuat data baru dengan user yg sama dan kios yg berbeda
            $statusRelasiKios['status_relasi_kios'] = true;
            $statusRelasiKios->update();
            $validatedData['tgl_sewa'] = Carbon::now()->format('Y-m-d');
            $validatedData['status_sewa'] = true;
            $validatedData['lokasi_id'] = $statusRelasiKios['lokasi_id'];
            SewaKios::create($validatedData);
            Alert::toast('Data penyewa Kios berhasil Di Update!', 'success');
            return redirect(route('sewa-kios.index'));
        } else {
            Alert::toast('Data penyewa Kios tidak ada yang di Update!', 'success');
            return redirect(route('sewa-kios.index'));
        }
    }

    public function destroy($id)
    {
        //
    }

    public function isActive($id)
    {
        $kios = SewaKios::findOrFail($id);
        if ($kios->status_sewa == 1) {
            $active['status_sewa'] = 0;
            $tgl_akhir_sewa['tgl_akhir_sewa'] =date('Y-m-d');
            $kios->update($active);
            $kios->update($tgl_akhir_sewa);

            Alert::toast('Data sewa kios berhasil di Non-aktifkan!', 'success');
            return redirect(route('sewa-kios.index'));
        } elseif ($kios->status_sewa == 0) {
            $active['status_sewa'] = 1;
            $tgl_akhir_sewa['tgl_akhir_sewa'] = NULL;
            $kios->update($active);
            $kios->update($tgl_akhir_sewa);

            Alert::toast('Data sewa kios berhasil di aktifkan!', 'success');
            return redirect(route('sewa-kios.index'));
        }
    }
}
