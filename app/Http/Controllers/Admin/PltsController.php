<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Models\Lokasi;
use App\Models\Plts;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PltsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataPlts = Plts::with('lokasi')->get();
        return view('pages.admin.plts.index', [
            'judul' => 'Data PLTS',
            'dataPlts' => $dataPlts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banyakLokasi = Lokasi::all();
        return view('pages.admin.plts.create', [
            'judul' => 'Tambah Data PLTS',
            'banyakLokasi' => $banyakLokasi
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData1 = $request->validate([
            'email' => 'required|email|unique:logins,email',
            'password' => 'required|min:6',
        ]);
        $validatedData2 = $request->validate([
            'nama_lengkap' => 'required|max:255',
            'lokasi_id' => 'required',
            'nip' => 'required|numeric',
            'no_hp' => 'required|numeric',
            'jenis_kelamin' => 'required'
        ]);

        // Menambahkan Akses Login
        $validatedData1['password'] = bcrypt($validatedData1['password']);
        $validatedData1['roles'] = 'plts';
        $validatedData1['is_active'] = true;
        $login = Login::create($validatedData1);

        // Menambahkan Data Petugas Berdasarkan Data Login
        $validatedData2['login_id'] = $login->id;
        Plts::create($validatedData2);

        Alert::toast('PLTS berhasil ditambahkan!','success');
        return redirect(route('master-plts.index'));
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
        $plts = Plts::findOrFail($id);
        $banyakLokasi = Lokasi::all();
        return view('pages.admin.plts.edit', [
            'judul' => 'Edit Data PLTS',
            'plts' => $plts,
            'banyakLokasi' => $banyakLokasi
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
        $validatedData2 = $request->validate([
            'nama_lengkap' => 'required|max:255',
            'lokasi_id' => 'required',
            'nip' => 'required|numeric',
            'no_hp' => 'required|numeric',
            'jenis_kelamin' => 'required'
        ]);

        $plts = Plts::findOrFail($id);
        // $login = Login::where('id', $user->login_id)->get();
        // $passwordLama = $plts->Login->password;

        if ($request->input('email') != $plts->Login->email) {
            // ddd($request->input('email').''. $user->Login->email);
            if ($request->input('password') != null) {
                $validatedData1 = $request->validate([
                    'email' => 'required|email|unique:Logins,email',
                    'password' => 'required|min:6'
                ]);
                $validatedData1['password'] = bcrypt($validatedData1['password']);
                $plts->Login->update($validatedData1);
            } else {
                $validatedData1 = $request->validate([
                    'email' => 'required|email|unique:Logins,email'
                ]);
                $plts->Login->update($validatedData1);
            }
        } elseif ($request->input('password') != null) {
            $validatedData1 = $request->validate([
                'password' => 'required|min:6'
            ]);
            $validatedData1['password'] = bcrypt($validatedData1['password']);
            $plts->Login->update($validatedData1);
        }

        // $plts->Login->update($validatedData1);

        $validatedData2['login_id'] = $plts->login_id;
        $plts->update($validatedData2);

        Alert::toast('PLTS berhasil diupdate!','success');

        return redirect(route('master-plts.index'));
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

    public function isActive($id)
    {
        $plts = Plts::findOrFail($id);
        if ($plts->Login->is_active == 1) {
            $active['is_active'] = 0;
            $login = Login::findOrFail($plts->Login->id);
            $login->update($active);
            Alert::toast('Status PLTS berhasil di Non-aktifkan!','success');
            return redirect(route('master-plts.index'));
        } elseif ($plts->Login->is_active == 0) {
            $active['is_active'] = 1;
            $login = Login::findOrFail($plts->Login->id);
            $login->update($active);
            Alert::toast('Status PLTS Berhasil di Diaktifkan!','success');
            return redirect(route('master-plts.index'));
        }
    }
}
