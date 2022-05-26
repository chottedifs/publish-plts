<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Lokasi;
use App\Models\Petugas;
use App\Models\Login;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PetugasController extends Controller
{
    public function index()
    {
        $banyakPetugas = Petugas::with('lokasi')->get();
        return view('pages.admin.petugas.index', [
            'judul' => 'Data Petugas',
            'banyakPetugas' => $banyakPetugas
        ]);
    }

    public function create()
    {
        $banyakLokasi = Lokasi::all();
        return view('pages.admin.petugas.create', [
            'judul' => 'Tambah Data Petugas',
            'banyakLokasi' => $banyakLokasi
        ]);
    }

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
        $validatedData1['roles'] = 'operator';
        $validatedData1['is_active'] = true;
        $login = Login::create($validatedData1);

        // Menambahkan Data Petugas Berdasarkan Data Login
        $validatedData2['login_id'] = $login->id;
        Petugas::create($validatedData2);

        Alert::toast('Petugas berhasil ditambahkan!','success');
        return redirect(route('master-petugas.index'));
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
        $petugas = Petugas::findOrFail($id);
        $banyakLokasi = Lokasi::all();
        return view('pages.admin.petugas.edit', [
            'judul' => 'Edit Data Petugas',
            'petugas' => $petugas,
            'banyakLokasi' => $banyakLokasi
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData2 = $request->validate([
            'nama_lengkap' => 'required|max:255',
            'lokasi_id' => 'required',
            'nip' => 'required|numeric',
            'no_hp' => 'required|numeric',
            'jenis_kelamin' => 'required'
        ]);

        $petugas = Petugas::findOrFail($id);
        // $login = Login::where('id', $user->login_id)->get();
        // $passwordLama = $petugas->Login->password;

        if ($request->input('email') != $petugas->Login->email) {
            // ddd($request->input('email').''. $user->Login->email);
            if ($request->input('password') != null) {
                $validatedData1 = $request->validate([
                    'email' => 'required|email|unique:Logins,email',
                    'password' => 'required|min:6'
                ]);
                $validatedData1['password'] = bcrypt($validatedData1['password']);
            } else {
                $validatedData1 = $request->validate([
                    'email' => 'required|email|unique:Logins,email'
                ]);
            }
        } elseif ($request->input('password') != null) {
            $validatedData1 = $request->validate([
                'password' => 'required|min:6'
            ]);
            $validatedData1['password'] = bcrypt($validatedData1['password']);
        }

        $petugas->Login->update($validatedData1);

        $validatedData2['login_id'] = $petugas->login_id;
        $petugas->update($validatedData2);

        Alert::toast('Petugas berhasil diupdate!','success');
        return redirect(route('master-petugas.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Petugas::destroy($id);
        // return redirect(route('master-petugas.index'));
    }
}
