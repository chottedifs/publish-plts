<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RelasiKios;
use App\Models\SewaKios;
use App\Models\HistoriKios;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class sewaKiosController extends Controller
{
    public function index()
    {
        $roles = Auth::user()->roles;
        if ($roles == "operator") {
            $lokasiPetugas = Auth::user()->Petugas->lokasi_id;
            // $lokasiKios = RelasiKios::with('Lokasi')->where('lokasi_id', $lokasiPetugas)->get();
            $sewaKios = SewaKios::with('RelasiKios','HistoriKios')->where('lokasi_id', $lokasiPetugas)->get();
            // $sewaKios = SewaKios::with('RelasiKios')->get();
        } elseif ($roles == "admin") {
            $sewaKios = SewaKios::with('RelasiKios','HistoriKios')->get();
        }

        // $sewaKios = SewaKios::with('RelasiKios','User')->get();
        // ddd($sewaKios);

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
            $relasiKios = RelasiKios::with('Kios','Lokasi')->where('lokasi_id', $lokasiPetugas)->get();
        } elseif($roles == "admin") {
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
            'relasi_kios_id' => 'required'
        ]);
        $statusRelasiKios = RelasiKios::findOrFail($validatedData['relasi_kios_id']);
        $statusRelasiKios['status_relasi_kios'] = true;
        $statusRelasiKios->update();

        $validatedData['status_sewa'] = true;
        $validatedData['lokasi_id'] = $statusRelasiKios['lokasi_id'];
        $sewa = SewaKios::create($validatedData);

        //* Create Histori Kios
        $dataHistori = [
            'user_id' => $validatedData['user_id'],
            'sewa_kios_id' => $sewa->id,
            'tgl_awal_sewa' => date('Y-m-d H:i:s'),
            'lokasi_id' => $validatedData['lokasi_id']
        ];
        HistoriKios::create($dataHistori);

        Alert::toast('Data penyewa kios berhasil ditambahkan!','success');
        return redirect(route('sewa-kios.index'));
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

    public function edit($id)
    {
        $sewaKios = SewaKios::findOrFail($id);
        $roles = Auth::user()->roles;
        if ($roles == "operator") {
            $lokasiPetugas = Auth::user()->Petugas->lokasi_id;
            $user = User::with('Lokasi')->where('lokasi_id', $lokasiPetugas)->get();
            $relasiKios = RelasiKios::with('Kios','Lokasi')->where('lokasi_id', $lokasiPetugas)->get();
        } elseif($roles == "admin") {
            $user = User::all();
            $relasiKios = RelasiKios::with('Kios')->get();
            // $banyakLokasi = Lokasi::all();
        }
        // ddd($user);
        return view('pages.admin.sewaKios.edit', [
            'judul' => 'Edit Data Sewa Kios',
            'sewaKios' => $sewaKios,
            'users' => $user,
            'relasiKios' => $relasiKios,
        ]);
    }

    public function update(Request $request, $id)
    {
        $sewaKios = SewaKios::findOrFail($id);
        $historiSebelumnya = HistoriKios::where('user_id', $sewaKios->user_id)->get()->last();

        // ddd($historiSebelumnya->tgl_awal_sewa);

        // Validasi Input
        $validatedData = $request->validate([
                'user_id' => 'required',
                'relasi_kios_id' => 'required'
            ]);

        if ($sewaKios != $historiSebelumnya){
            $updateHistori = [
                'tgl_awal_sewa' => $historiSebelumnya->tgl_awal_sewa,
                'tgl_akhir_sewa' => date('Y-m-d H:i:s')
            ];
            HistoriKios::where('user_id', $sewaKios->user_id)->update($updateHistori);
        }

        // ddd($updateHistori);

        $sewaKios->update($validatedData);

        // Create Histori Kios
        $dataHistori = [
            'user_id' => $validatedData['user_id'],
            'sewa_kios_id' => $sewaKios->id,
            'tgl_awal_sewa' => date('Y-m-d H:i:s'),
            'lokasi_id' => $sewaKios->lokasi_id
        ];
        HistoriKios::create($dataHistori);

        Alert::toast('Data penyewa kios berhasil diupdate!','success');
        return redirect(route('sewa-kios.index'));
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
}
