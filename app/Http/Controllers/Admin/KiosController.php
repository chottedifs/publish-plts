<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kios;
use RealRashid\SweetAlert\Facades\Alert;

class KiosController extends Controller
{
    public function index()
    {
        $banyakKios = Kios::all();
        return view('pages.admin.kios.index', [
            'judul' => 'Kios',
            'banyakKios' => $banyakKios
        ]);
    }

    public function create()
    {
        return view('pages.admin.kios.create', [
            'judul' => "Tambah Kios"
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kios' => 'required|max:255',
            'tempat' => 'required'
        ]);
        $validatedData['status_kios'] = false;
        Kios::create($validatedData);

        Alert::toast('Kios berhasil ditambahkan!', 'success');
        return redirect(route('master-kios.index'));
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
        $kios = Kios::findOrFail($id);
        return view('pages/admin/kios/edit', [
            'judul' => 'Edit Kios',
            'kios' => $kios
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_kios' => 'required|max:255',
            'tempat' => 'required'
        ]);

        $data = $request->all();

        $kios = Kios::findOrFail($id);
        $kios->update($data);

        Alert::toast('Kios berhasil diupdate!', 'success');
        return redirect(route('master-kios.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Kios::destroy($id);
        // return redirect(route('master-kios.index'));
    }
}
