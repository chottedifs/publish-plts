<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TarifKios;
use RealRashid\SweetAlert\Facades\Alert;

class TarifKiosController extends Controller
{
    public function index()
    {
        $tarifKios = TarifKios::all();
        return view('pages.admin.tarifKios.index', [
            'judul' => 'Master Data Tarif Kios',
            'tarifKios' => $tarifKios
        ]);
    }

    public function create()
    {
        return view('pages.admin.tarifKios.create', [
            'judul' => 'Tambah Master Data Tarif Kios'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tipe' => 'required|max:255',
            'harga' => 'required|numeric'
        ]);

        TarifKios::create($validatedData);

        Alert::toast('Data Tarif kios berhasil ditambahkan!','success');
        return redirect(route('master-tarifKios.index'));
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
        $tarifKios = TarifKios::findOrFail($id);
        return view('pages.admin.tarifKios.edit', [
            'judul' => 'Edit Master Data Tarif Kios',
            'tarifKios' => $tarifKios
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $tarifKios = TarifKios::findOrFail($id);
        $tarifKios->update($data);

        Alert::toast('Data Tarif kios berhasil diupdate!','success');
        return redirect(route('master-tarifKios.index'));
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
