<?php

namespace App\Http\Controllers;

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

        return view("master.katalog.index", compact('katalog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('master.katalog.create');
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
        $katalog->deskripsi = $request->deskripsi;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
        }
        $katalog->foto = $fileName;
        $katalog->save();


        return redirect()->route('katalog.index')->with('success', 'Katalog berhasil ditambahkan');
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
    public function edit(Katalog $katalog)
    {
        return view('master.katalog.edit', compact('katalog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Katalog  $katalog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Katalog $katalog)
    {
        //
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga' => ['required', 'numeric'],
            'stok' => ['required', 'integer'],
            'foto' => ['nullable', 'image', 'max:2048'],

        ]);



        $katalog->nama = $request->nama;
        $katalog->harga = $request->harga;
        $katalog->stok = $request->stok;
        if ($request->hasFile('foto')) {
            $pathRemove = public_path('uploads/' .$katalog->foto);
            unlink($pathRemove);
            $file = $request->file('foto');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $katalog->foto = $fileName;
        }
        $katalog->save();

        return redirect()->route('katalog.index')->with('success', 'Katalog berhasil diupdate');
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
        return redirect()->route('katalog.index')->with('berhasil dihapus');
    }

    public function json($id)
    {

        $data = Katalog::where('id', $id)->first();

        return response()->json($data);

    }
}
