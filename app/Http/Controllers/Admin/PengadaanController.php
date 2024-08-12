<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengadaanItem;
use App\Models\Katalog;
use App\Models\Pengadaan;
use App\Models\User;
use Duitku\Api;
use Duitku\Config;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PDF;
class PengadaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemesanan = Pengadaan::all();
        return view('admin.pengadaan.index',compact('pemesanan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $konsumen = User::select('nama as label', 'id as value')->where('role', 'pelanggan')->get()->toArray();
        $produk = Katalog::select('nama as label', 'id as value')->get()->toArray();

        return view('admin.pengadaan.create',compact('konsumen', 'produk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'supplier' => 'required',
            'tgl' => 'required',
        ]);

        $date = strtotime(date("Y-m-d H:i:s"));
        $kode = IdGenerator::generate(['table' => 'pengadaan', 'field' => 'kode', 'length' => 17, 'prefix' => 'BLI-' . $date]);
        $data = new Pengadaan();
        $data->kode = $kode;
        $data->tgl = $request->tgl;
        $data->supplier = $request->supplier;
        $data->status = 'pending';
        $data->save();

        foreach ($request->lines as $item) {
            $itemPesanan = new PengadaanItem();
            $itemPesanan->katalog_id = $item['produk_id'];
            $itemPesanan->pengadaan_id = $data->id;
            $itemPesanan->jumlah = $item['qty'];
            $itemPesanan->harga = $item['harga'];
            $itemPesanan->save();
        }

        return redirect()->back()->with(['success' => 'Berhasil Membuat Pengajuan Pengadaan']);
    }

    public function status($id, Request $request)
    {
        $data = Pengadaan::where('id', $id)->first();
        $data->status = $request->status;
        $data->save();
 
        if($request->status == 'diterima'){
         foreach ($data->item as $item) {
             $itemPesanan = Katalog::where('id', $item->katalog_id)->first();
             $itemPesanan->stok += $item->jumlah;
             $itemPesanan->save();
         }
        }
         return redirect()->back()->with('success', 'Data pemesanan berhasil diperbarui.');
   }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Pengadaan::where('id', $id)->first();

        return view('admin.pengadaan.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Pengadaan::where('id', $id)->first();
        $konsumen = User::select('nama as label', 'id as value')->where('role', 'pelanggan')->get()->toArray();
        $produk = Katalog::select('nama as label', 'id as value')->get()->toArray();

        return view('admin.pengadaan.edit', compact('data', 'konsumen', 'produk'));
   }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        // dd($request->all());

        $request->validate([
            'supplier' => 'required',
            'tgl' => 'required',
        ]);

        $data = Pengadaan::where('id', $id)->first();
        $data->tgl = $request->tgl;
        $data->supplier = $request->supplier;
        $data->status = $request->status;
        $data->save();

        foreach ($request->lines as $item) {
            if(array_key_exists('id', $item)){
                $itemPesanan = PengadaanItem::where('id', $item['id'])->first();
            }else{
                $itemPesanan = new PengadaanItem();
            }
            $itemPesanan->pengadaan_id = $data->id;
            $itemPesanan->katalog_id = $item['produk_id'];
            $itemPesanan->jumlah = $item['qty'];
            $itemPesanan->harga = $item['harga'];
            $itemPesanan->save();
        }
           return redirect()->route('admin.pengadaan.index')->with('success', 'Data pemesanan berhasil diperbarui.');
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
    {
        $data = Pengadaan::where('id', $id)->delete();

        return redirect()->route('admin.pengadaan.index')->with('succes', 'data berhasil dihapus');
    }

    
    public function report(Request $request)
    {
        $tgl = explode(" - ",$request->tgl);
        $data = Pengadaan::whereBetween('tgl', $tgl)->get();
        $config = [
            'format' => 'A4-L' // Landscape
        ];

        $pdf = PDF::loadView('pdf.pengadaan', [
            'data' => $data,
            'tgl' =>$tgl
        ], [ ], $config);

        return $pdf->stream('Laporan Pengadaan.pdf');

    }
    
}
