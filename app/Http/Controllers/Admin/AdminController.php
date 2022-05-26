<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Lokasi;
use App\Models\Admin;
use App\Models\Login;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function index()
    {
        $banyakAdmin = Admin::with('lokasi')->get();
        return view('pages.admin.admin.index', [
            'judul' => 'Data Admin',
            'banyakAdmin' => $banyakAdmin
        ]);
    }

    public function create()
    {
        $banyakLokasi = Lokasi::all();
        return view('pages.admin.admin.create', [
            'judul' => 'Tambah Data Admin',
            'banyakLokasi' => $banyakLokasi
        ]);
    }

    public function store(Request $request)
    {
        // Validasi Form Admin
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
        $validatedData1['roles'] = 'admin';
        $validatedData1['is_active'] = true;
        $login = Login::create($validatedData1);

        // Menambahkan Data admin Berdasarkan Data Login
        $validatedData2['login_id'] = $login->id;
        Admin::create($validatedData2);

        Alert::toast('Data admin berhasil ditambahkan!','success');
        return redirect(route('master-admin.index'));
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
        $admin = Admin::findOrFail($id);
        $banyakLokasi = Lokasi::all();
        return view('pages.admin.admin.edit', [
            'judul' => 'Edit Data Admin',
            'admin' => $admin,
            'banyakLokasi' => $banyakLokasi
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi Form Update
        $validatedData2 = $request->validate([
            'nama_lengkap' => 'required|max:255',
            'lokasi_id' => 'required',
            'nip' => 'required|numeric',
            'no_hp' => 'required|numeric',
            'jenis_kelamin' => 'required'
        ]);

        $admin = Admin::findOrFail($id);

        if ($request->input('email') != $admin->Login->email) {
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

        // Update data database
        $admin->Login->update($validatedData1);
        $validatedData2['login_id'] = $admin->login_id;
        $admin->update($validatedData2);

        Alert::toast('Data admin berhasil diupdate!','success');
        return redirect(route('master-admin.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Admin::destroy($id);
        // return redirect(route('master-admin.index'));
    }
}
