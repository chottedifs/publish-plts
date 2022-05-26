<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TarifKwh;
use RealRashid\SweetAlert\Facades\Alert;

class TarifKwhController extends Controller
{
    public function index()
    {
        $tarifKwh = TarifKwh::all();
        return view('pages.admin.tarifKwh.index', [
            'judul' => 'Master Data Tarif Dasar Kwh',
            'tarifKwh' => $tarifKwh
        ]);
    }

    public function create()
    {
        return view('pages.admin.tarifKwh.create', [
            'judul' => 'Tambah Master Data Tarif Dasar Kwh'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_kwh' => 'required|max:255',
            'harga' => 'required|numeric'
        ]);

        TarifKwh::create($validatedData);

        Alert::toast('Data penyewa kios berhasil ditambahkan!','success');
        return redirect(route('master-tarifKwh.index'));
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
        $tarifKwh = TarifKwh::findOrFail($id);
        return view('pages.admin.TarifKwh.edit', [
            'judul' => 'Edit Master Data Tarif Dasar Kwh',
            'tarifKwh' => $tarifKwh
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $tarifKwh = TarifKwh::findOrFail($id);
        $tarifKwh->update($data);

        Alert::toast('Data penyewa kios berhasil diupdate!','success');
        return redirect(route('master-tarifKwh.index'));
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
