<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lokasi;
use RealRashid\SweetAlert\Facades\Alert;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasis = Lokasi::all();
        return view('pages.admin.lokasi.index', [
            'judul' => 'Master Data Lokasi Kios',
            'lokasi' => $lokasis
        ]);
    }

    public function create()
    {
        return view('pages.admin.lokasi.create', [
            'judul' => 'Tambah Master Data Lokasi Kios'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_lokasi' => 'required|max:255',
        ]);

        Lokasi::create($validatedData);

        Alert::toast('Kios berhasil ditambahkan!','success');
        return redirect(route('master-lokasi.index'));
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
        $lokasis = Lokasi::findOrFail($id);
        return view('pages.admin.lokasi.edit', [
            'judul' => 'Edit Master Data Lokasi Kios',
            'lokasi' => $lokasis
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $lokasis = Lokasi::findOrFail($id);
        $lokasis->update($data);

        Alert::toast('Kios berhasil diupdate!','success');
        return redirect(route('master-lokasi.index'));
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
