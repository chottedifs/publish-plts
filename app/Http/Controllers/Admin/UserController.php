<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataUser;
use App\Models\Login;
use App\Models\Lokasi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $roles = Auth::user()->roles;
        if ($roles == "operator") {
            $lokasiPetugas = Auth::user()->Petugas->lokasi_id;
            $user = User::with('Lokasi')->where('lokasi_id', $lokasiPetugas)->get();
        } else {
            $user = User::with('Lokasi')->get();
        }
        // $user = User::with('Lokasi')->get();
        return view('pages.admin.user.index', [
            'judul' => 'Biodata User',
            'users' => $user
        ]);
    }

    public function create()
    {
        $roles = Auth::user()->roles;
        if ($roles == "operator") {
            $lokasiPetugas = Auth::user()->Petugas->lokasi_id;
            $banyakLokasi = Lokasi::where('id', $lokasiPetugas)->get();
        } elseif ($roles == "admin") {
            $banyakLokasi = Lokasi::all();
        }
        return view('pages.admin.user.create', [
            'judul' => 'Tambah User',
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
            'nik' => 'required|numeric|digits_between:15,16',
            'rekening' => 'required|numeric',
            'no_hp' => 'required|numeric|digits_between:12,13',
            'jenis_kelamin' => 'required'
        ]);
        $validatedData1['password'] = bcrypt($validatedData1['password']);
        $validatedData1['roles'] = 'user';
        $validatedData1['is_active'] = true;

        $login = Login::create($validatedData1);

        $validatedData2['login_id'] = $login->id;
        User::create($validatedData2);

        Alert::toast('Data user berhasil ditambahkan!', 'success');
        return redirect(route('master-user.index'));
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
        $user = User::findOrFail($id);

        // Cek Lokasi User
        $roles = Auth::user()->roles;
        if ($roles == "operator") {
            $lokasiPetugas = Auth::user()->Petugas->lokasi_id;
            $banyakLokasi = Lokasi::where('id', $lokasiPetugas)->get();
        } elseif ($roles == "admin") {
            $banyakLokasi = Lokasi::all();
        }

        // Halaman
        return view('pages.admin.user.edit', [
            'judul' => 'Edit Data User',
            'user' => $user,
            'banyakLokasi' => $banyakLokasi
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData2 = $request->validate([
            'nama_lengkap' => 'required|max:255',
            'lokasi_id' => 'required',
            'nik' => 'required|numeric',
            'rekening' => 'required|numeric',
            'no_hp' => 'required|numeric',
            'jenis_kelamin' => 'required'
        ]);

        $user = User::findOrFail($id);

        if ($request->input('email') != $user->Login->email) {
            // ddd($request->input('email').''. $user->Login->email);
            if ($request->input('password') != null) {
                $validatedData1 = $request->validate([
                    'email' => 'required|email|unique:Logins,email',
                    'password' => 'required|min:6'
                ]);
                $validatedData1['password'] = bcrypt($validatedData1['password']);
                $user->Login->update($validatedData1);
            } else {
                $validatedData1 = $request->validate([
                    'email' => 'required|email|unique:Logins,email'
                ]);
                $user->Login->update($validatedData1);
            }
        } elseif ($request->input('password') != null) {
            $validatedData1 = $request->validate([
                'password' => 'required|min:6'
            ]);
            $validatedData1['password'] = bcrypt($validatedData1['password']);
            $user->Login->update($validatedData1);
        }



        $validatedData2['login_id'] = $user->login_id;
        $user->update($validatedData2);

        Alert::toast('Data user berhasil diupdate!', 'success');
        return redirect(route('master-user.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // User::destroy($id);
        // return redirect(route('master-user.index'));
    }

    public function isActive($id)
    {
        // $user = User::with('Login')->where('id',$id)->get();
        $user = User::with('Login')->findOrFail($id);
        // ddd($user->Login->is_active);
        if ($user->Login->is_active == 1) {
            $active['is_active'] = 0;
            $login = Login::findOrFail($user->Login->id);
            $login->update($active);
            // $user->Login->is_active->update($active);
            Alert::toast('Data user berhasil di Non-aktifkan!', 'success');
            return redirect(route('master-user.index'));
        } elseif ($user->Login->is_active == 0) {
            $active['is_active'] = 1;
            $login = Login::findOrFail($user->Login->id);
            $login->update($active);
            Alert::toast('Data user berhasil di aktifkan!', 'success');
            return redirect(route('master-user.index'));
        }
    }
}
