<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemPemesanan;
use App\Models\Katalog;
use App\Models\Pemesanan;
use App\Models\User;
use Duitku\Api;
use Duitku\Config;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PDF;
class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemesanan = Pemesanan::all();
        return view('admin.pembayaran.index',compact('pemesanan'));
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

        return view('admin.pembayaran.create',compact('konsumen', 'produk'));
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

        $date = strtotime(date("Y-m-d H:i:s"));
        $kode = IdGenerator::generate(['table' => 'pemesanans', 'field' => 'kode_transaksi', 'length' => 17, 'prefix' => 'TRX-' . $date]);
        $pemesanan = new Pemesanan();
        $pemesanan->kode_transaksi = $kode;
        $pemesanan->tgl_penyewaan = $request->tgl;
        $pemesanan->durasi = $request->lama;
        $pemesanan->jam_pengambilan = $request->waktu;
        $pemesanan->jaminan = $request->jaminan;
        $pemesanan->user_id = $request->pelanggan_id;
        $pemesanan->status_penyewaan = $request->status;
        $pemesanan->save();

        foreach ($request->lines as $item) {
            $itemPesanan = new ItemPemesanan();
            $itemPesanan->katalog_id = $item['produk_id'];
            $itemPesanan->pemesanan_id = $pemesanan->id;
            $itemPesanan->jumlah = $item['qty'];
            $itemPesanan->save();
        }

        return redirect()->back()->with(['success' => 'Berhasil Membuat Pesanan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Pemesanan::where('id', $id)->first();
        return view('admin.pembayaran.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Pemesanan::where('id', $id)->first();
        $konsumen = User::select('nama as label', 'id as value')->where('role', 'pelanggan')->get()->toArray();
        $produk = Katalog::select('nama as label', 'id as value')->get()->toArray();

        return view('admin.pembayaran.edit', compact('data', 'konsumen', 'produk'));
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

        $pemesanan = Pemesanan::where('id', $id)->first();
        $pemesanan->tgl_penyewaan = $request->tgl;
        $pemesanan->durasi = $request->lama;
        $pemesanan->jam_pengambilan = $request->waktu;
        $pemesanan->jaminan = $request->jaminan;
        $pemesanan->user_id = $request->pelanggan_id;
        $pemesanan->status_penyewaan = $request->status;
        $pemesanan->save();

        foreach ($request->lines as $item) {
            if(array_key_exists('id', $item)){
                $itemPesanan = ItemPemesanan::where('id', $item['id'])->first();
            }else{
                $itemPesanan = new ItemPemesanan();
            }
            $itemPesanan->katalog_id = $item['produk_id'];
            $itemPesanan->pemesanan_id = $pemesanan->id;
            $itemPesanan->jumlah = $item['qty'];
            $itemPesanan->save();
        }
           return redirect()->route('admin.pemesanan.index')->with('success', 'Data pemesanan berhasil diperbarui.');
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
   public function destroy(Pemesanan $pemesanan)
        {
        $pemesanan->delete();

        return redirect()->route('pemesanan.index')->with('succes', 'data berhasil dihapus');
    }
    
    public function json($id)
    {

        $data = Pemesanan::with(['item' => function($q){
            return $q->with('katalog');
        }])->where('id', $id)->first();

        return response()->json($data);

    }

    
    public function pdf($id)
    {
        $data = Pemesanan::where('id', $id)
        ->first();

        $pdf = PDF::loadView('pdf.invoice', [
            'data' => $data,
        ], [ ], [
            'format' => 'A4-P'
        ]);

        return $pdf->stream('Invoice '. $data->nomor .'.pdf');
    }

    
    public function report(Request $request)
    {
        $tgl = explode(" - ",$request->tgl);
        $data = Pemesanan::with(['user'])
        ->whereBetween('tgl_penyewaan', $tgl)
        ->latest()->get();
        $config = [
            'format' => 'A4-L' // Landscape
        ];

        $pdf = PDF::loadView('pdf.pemesanan', [
            'data' => $data,
            'tgl' =>$tgl
        ], [ ], $config);

        return $pdf->stream('Laporan Pesanan.pdf');

    }
}
