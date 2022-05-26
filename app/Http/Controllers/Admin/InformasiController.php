<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Informasi;
use RealRashid\SweetAlert\Facades\Alert;

class InformasiController extends Controller
{
    public function index()
    {
        $informations = Informasi::all();
        return view('pages.admin.informasi.index', [
            'judul' => 'Master Data Informasi',
            'informasi' => $informations
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

        if ($request->hasfile('gambar')) {
            $gambar = date('Ymd-His').'-'.str_replace(' ','-', $request->file('gambar')->getClientOriginalName());
            $request->file('gambar')->move(public_path('images'), $gambar);
            Informasi::create($validatedData);

            Alert::toast('Data informasi berhasil ditambahkan!','success');
            return redirect(route('master-informasi.index'));
        }
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

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $informations = Informasi::findOrFail($id);
        $informations->update($data);

        Alert::toast('Data informasi berhasil diupdate!','success');
        return redirect(route('master-informasi.index'));
    }

    public function destroy($id)
    {
        Informasi::destroy($id);
        return redirect(route('master-informasi.index'));
    }
}
