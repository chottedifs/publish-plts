<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Informasi;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\CloudinaryStorage;

class InformasiController extends Controller
{
    public function index()
    {
        $informations = Informasi::all();
        return view('pages.admin.informasi.index', [
            'judul' => 'Master Data Informasi',
            'informasi' => $informations,
            // 'gambar' => Informasi::get()
        ]);
    }

    public function create()
    {
        $informations = Informasi::all();
        return view('pages.admin.informasi.create', [
            'judul' => 'Tambah Master Data Informasi',
            'informasi' => $informations
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'deskripsi' => 'required|max:255',
            'gambar' => 'required',
            'gambar.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);

        $gambar =$request->file('gambar');

        $validatedData['gambar'] = CloudinaryStorage::upload($gambar->getRealPath(), $gambar->getClientOriginalName());

        // $validatedData['gambar'] = $request->file('gambar')->store(
        //     'images/information', 'public'
        // );

        Informasi::create($validatedData);

        Alert::toast('Data informasi berhasil ditambahkan!','success');
        return redirect(route('master-informasi.index'));
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
        $informations = Informasi::findOrFail($id);
        return view('pages.admin.informasi.edit', [
            'judul' => 'Edit Master Data Informasi',
            'informasi' => $informations
        ]);
    }

    public function update(Request $request, Informasi $informations)
    {
        $data = $request->all();

        $gambar =$request->file('gambar');

        $data['gambar'] = CloudinaryStorage::replace($informations->gambar, $gambar->getRealPath(), $gambar->getClientOriginalName());

        // $data['gambar'] = $request->file('gambar')->store(
        //     'images/information', 'public'
        // );

        // $informations = Informasi::findOrFail($id);
        $informations->update($data);

        Alert::toast('Data informasi berhasil diupdate!','success');
        return redirect(route('master-informasi.index'));
    }

    public function destroy($id)
    {
        $informations = Informasi::findOrFail($id);
        $informations->delete();

        Alert::toast('Data informasi berhasil dihapus!','success');
        return redirect(route('master-informasi.index'));
    }
}
