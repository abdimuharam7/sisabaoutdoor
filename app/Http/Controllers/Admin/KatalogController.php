<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Katalog;
use Illuminate\Http\Request;
use PHPUnit\Framework\Constraint\FileExists;

class KatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $katalog = Katalog::all();

        return view("admin.katalog.index", compact('katalog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.katalog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validasi data
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric'],
            'stok' => ['required', 'integer'],
            'foto' => ['image', 'max:2048'],


        ]);
        $katalog = new Katalog();
        $katalog->nama = $request->nama;
        $katalog->harga = $request->harga;
        $katalog->stok = $request->stok;
        $katalog->harga_beli = $request->harga_beli;
        $katalog->satuan = $request->satuan;
        $katalog->deskripsi = $request->deskripsi;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
        }
        $katalog->foto = $fileName;
        $katalog->save();


        return redirect()->route('admin.katalog.index')->with('success', 'Katalog berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Katalog  $katalog
     * @return \Illuminate\Http\Response
     */
    public function show(Katalog $katalog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Katalog  $katalog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $katalog = Katalog::where('id', $id)->first();

        return view('admin.katalog.edit', compact('katalog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Katalog  $katalog
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        //]
        // dd($request->all());
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric'],
            'stok' => ['required', 'integer'],
            'foto' => ['nullable', 'image', 'max:2048'],

        ]);
        $katalog = Katalog::where('id', $id)->first();
        $katalog->nama = $request->nama;
        $katalog->harga = $request->harga;
        $katalog->stok = $request->stok;
        $katalog->harga_beli = $request->harga_beli;
        $katalog->satuan = $request->satuan;
        $katalog->deskripsi = $request->deskripsi;
        if ($request->hasFile('foto')) {
            $pathRemove = public_path('uploads/' .$katalog->foto);
            unlink($pathRemove);
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $katalog->foto = $fileName;
        }
        $katalog->save();

        return redirect()->route('admin.katalog.index')->with('success', 'Katalog berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Katalog  $katalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Katalog $katalog)
    {
        $pathRemove = public_path('uploads/' .$katalog->foto);
        if(file_exists($pathRemove)){
            unlink($pathRemove);
        }
        $katalog->delete();
        return redirect()->route('admin.katalog.index')->with('berhasil dihapus');
    }

    public function json($id)
    {

        $data = Katalog::where('id', $id)->first();

        return response()->json($data);

    }
}
