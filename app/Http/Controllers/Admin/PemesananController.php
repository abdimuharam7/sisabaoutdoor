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
use Mail;
use App\Mail\InvoiceMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
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

        $rules = [
            'tgl' => 'required',
            'lama' => 'required',
            'jaminan' => 'required',
            'pelanggan_id' => 'required',
            'status' => 'required',
            'status_pembayaran' => 'required',
            'lines.*.produk_id' => 'required'
        ];

        $pesan = [
            'tgl.required' => 'Tanggal harus diisi',
            'lama.required' => 'Durasi harus diisi!',
            'jaminan.required' => 'Jaminan harus diisi',
            'pelanggan_id.required' => 'Pelanggan harus diisi',
            'status.required' => 'Status Penyewaan harus diisi',
            'status_pembayaran.required' => 'Status Pembayaran harus diisi',
            'lines.*' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            // dd($validator->errors());
            return back()->withErrors($validator->errors())->withInput();
        }else{
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
            $pemesanan->status_pembayaran = $request->status_pembayaran;
            $pemesanan->save();

            foreach ($request->lines as $item) {
                $itemPesanan = new ItemPemesanan();
                $itemPesanan->katalog_id = $item['produk_id'];
                $itemPesanan->pemesanan_id = $pemesanan->id;
                $itemPesanan->jumlah = $item['qty'];
                $itemPesanan->save();
            }

            
            $pdf = PDF::loadView('pdf.invoice', [
                'data' => $pemesanan,
                'type' => 'invoice'
            ], [ ], [
                'format' => 'A4-P'
            ]);
    
            Mail::send('emails.invoice', $data->toArray(), function($message)use($pemesanan, $pdf) {
                $message->to($pemesanan->user->email, $data->user->nama)
                        ->subject("Invoice ". $pemesanan->kode_transaksi)
                        ->attachData($pdf->output(), "Invoice ". $pemesanan->kode_transaksi ." .pdf");
            });
        }

        return redirect()->route('admin.pemesanan.show', $pemesanan->id)->with(['success' => 'Berhasil Membuat Pesanan']);
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
        $pemesanan = Pemesanan::where('id', $id)->first();
        $pemesanan->tgl_penyewaan = $request->tgl;
        $pemesanan->durasi = $request->lama;
        $pemesanan->jam_pengambilan = $request->waktu;
        $pemesanan->jaminan = $request->jaminan;
        $pemesanan->user_id = $request->pelanggan_id;
        $pemesanan->status_penyewaan = $request->status;
        $pemesanan->status_pembayaran = $request->status_pembayaran;
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

   public function bayar($id, Request $request)
   {
       $pemesanan = Pemesanan::where('id', $id)->first();
       $pemesanan->status_pembayaran = $request->status;
       $pemesanan->save();

       if($request->status == 'Dibayar'){
        foreach ($pemesanan->item as $item) {
            $itemPesanan = Katalog::where('id', $item->katalog_id)->first();
            $itemPesanan->stok -= $item->jumlah;
            $itemPesanan->save();
        }
       }
        return redirect()->back()->with('success', 'Data pemesanan berhasil diperbarui.');
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

        return redirect()->route('admin.pemesanan.index')->with('succes', 'data berhasil dihapus');
    }
    
    public function json($id)
    {

        $data = Pemesanan::with(['item' => function($q){
            return $q->with('katalog');
        }])->where('id', $id)->first();

        return response()->json($data);

    }

    
    public function pdf($id, Request $request)
    {
        $data = Pemesanan::where('id', $id)
        ->first();

        $type = $request->type;

        $pdf = PDF::loadView('pdf.invoice', [
            'data' => $data,
            'type' => $type,
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

    public function keterlambatan(Request $request)
    {
        $tgl = explode(" - ",$request->tgl);

        $today = Carbon::now();
        $data = Pemesanan::with(['user'])
        ->whereBetween('tgl_penyewaan', $tgl)
        ->latest()->get();
        // $data = Pemesanan::where(function ($query) use ($today) {
        //     $query->whereDate('tgl_penyewaan', '>=', $today)
        //         ->orWhere(function ($subquery) use ($today) {
        //             $subquery->whereDate('tgl_penyewaan', '=', $today)
        //                 ->whereTime('jam_pengambilan', '>=', $today->toTimeString());
        //         });
        // })
        // ->where(function ($query) {
        //     $query->whereDate('tgl_penyewaan', '<=', Carbon::now()->addDays(7))
        //         ->orWhere(function ($subquery) {
        //             $subquery->whereDate('tgl_penyewaan', '=', Carbon::now()->addDays(7))
        //                 ->whereTime('jam_pengambilan', '<=', Carbon::now()->addDays(7)->toTimeString());
        //         });
        // })
        // ->get();
        // dd($data);
        $config = [
            'format' => 'A4-L' // Landscape
        ];

        $pdf = PDF::loadView('pdf.keterlambatan', [
            'data' => $data,
            'tgl' =>$tgl
        ], [ ], $config);

        return $pdf->stream('Laporan Keterlambatan.pdf');
    }
}
