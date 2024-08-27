<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use App\Models\Katalog;
use App\Models\Pengembalian;
use App\Models\Pemesanan;
use App\Models\ItemPemesanan;
use App\Models\User;
use Duitku\Api;
use Duitku\Config;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Validator;
class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pemesanan = Pengembalian::all();
        return view('admin.pengembalian.index',compact('pemesanan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pengembalian = Pengembalian::latest()->get()->pluck('pemesanan_id');

        $pemesanan = Pemesanan::select('kode_transaksi as label', 'id as value')
        ->where('status_penyewaan', 'diterima')->whereNotIn('id', $pengembalian)->get();

        return view('admin.pengembalian.create',compact('pemesanan'));
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
            'pemesanan_id' => 'required',
            'tgl' => 'required',
        ];

        $pesan = [
            'tgl.required' => 'Tanggal harus diisi',
            'pemesanan_id.required' => 'Pesanan harus diisi!'
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            // dd($validator->errors());
            return back()->withErrors($validator->errors())->withInput();
        }else{
            // dd($request->all());
            $date = strtotime(date("Y-m-d H:i:s"));
            $kode = IdGenerator::generate(['table' => 'pengembalians', 'field' => 'kode', 'length' => 17, 'prefix' => 'RTN-' . $date]);
            $data = new Pengembalian();
            $data->kode = $kode;
            $data->pemesanan_id = $request->pemesanan_id;
            $data->tgl = Carbon::parse($request->tgl);
            $data->telat = $request->lambat;
            $data->status = $request->status;
            $data->total = $request->total;
            $data->save();

            foreach ($request->lines as $item) {
                $itemPesanan = new Denda();
                $itemPesanan->pengembalian_id = $data->id;
                $itemPesanan->pesan_item_id = $item['pesan_line_id'];
                $itemPesanan->katalog_id = $item['produk_id'];
                $itemPesanan->rusak_ringan = $item['rusak_ringan'];
                $itemPesanan->rusak_sedang = $item['rusak_sedang'];
                $itemPesanan->rusak_total = $item['rusak_total'];
                $itemPesanan->hilang = $item['hilang'];
                $itemPesanan->telat = $item['lambat'];
                $itemPesanan->total = $item['denda'];
                $itemPesanan->save();

                $rusak = $item['rusak_ringan'] + $item['rusak_sedang'] + $item['rusak_total'] + $item['hilang'];

                $pesanan = ItemPemesanan::where('id', $item['pesan_line_id'])->first();
                $kt = Katalog::where('id', $item['produk_id'])->first();
                $kt->stok += $pesanan->jumlah - $rusak;
                $kt->save();
            }

            return redirect()->route('admin.pengembalian.show', $data->id)->with(['success' => 'Berhasil Membuat Pesanan']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Pengembalian::where('id', $id)->first();
        $pemesanan = Pemesanan::select('kode_transaksi as label', 'id as value')
        ->where('status_penyewaan', 'diterima')->get()->toArray();
        $lines = ItemPemesanan::where('pemesanan_id', $data->pemesanan_id)->get();
        return view('admin.pengembalian.show', compact('data', 'pemesanan', 'lines'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Pengembalian::where('id', $id)->first();
        $pemesanan = Pemesanan::select('kode_transaksi as label', 'id as value')
        ->where('status_penyewaan', 'diterima')->get()->toArray();
        $lines = ItemPemesanan::where('pemesanan_id', $data->pemesanan_id)->get();
        return view('admin.pengembalian.edit', compact('data', 'pemesanan', 'lines'));
   }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $rules = [
            'pemesanan_id' => 'required',
            'tgl' => 'required',
        ];

        $pesan = [
            'tgl.required' => 'Tanggal harus diisi',
            'pemesanan_id.required' => 'Pesanan harus diisi!'
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            // dd($validator->errors());
            return back()->withErrors($validator->errors())->withInput();
        }else{
            $date = strtotime(date("Y-m-d H:i:s"));
            $kode = IdGenerator::generate(['table' => 'pengembalians', 'field' => 'kode', 'length' => 17, 'prefix' => 'RTN-' . $date]);
            $data = Pengembalian::where('id', $id)->first();
            $data->kode = $kode;
            $data->pemesanan_id = $request->pemesanan_id;
            $data->tgl = Carbon::parse($request->tgl);
            $data->telat = $request->lambat;
            $data->status = $request->status;
            $data->total = $request->total;
            $data->save();

            foreach ($request->lines as $item) {
                $itemPesanan = new Denda();
                $itemPesanan->pengembalian_id = $data->id;
                $itemPesanan->pesan_item_id = $item['pesan_line_id'];
                $itemPesanan->katalog_id = $item['produk_id'];
                $itemPesanan->rusak_ringan = $item['rusak_ringan'];
                $itemPesanan->rusak_sedang = $item['rusak_sedang'];
                $itemPesanan->rusak_total = $item['rusak_total'];
                $itemPesanan->hilang = $item['hilang'];
                $itemPesanan->telat = $item['lambat'];
                $itemPesanan->total = $item['denda'];
                $itemPesanan->save();

                $rusak = $item['rusak_ringan'] + $item['rusak_sedang'] + $item['rusak_total'] + $item['hilang'];

                $pesanan = ItemPemesanan::where('id', $item['pesan_line_id'])->first();
                $kt = Katalog::where('id', $item['produk_id'])->first();
                $kt->stok += $pesanan->jumlah - $rusak;
                $kt->save();
            }

           return redirect()->route('admin.pengembalian.show', $data->id)->with('success', 'Data pemesanan berhasil diperbarui.');
        }
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
        {
            $data = Pengembalian::where('id', $id)->delete();

        return redirect()->route('admin.pengembalian.index')->with('succes', 'data berhasil dihapus');
    }
    
    public function pdf($id)
    {
        $data = Pengembalian::where('id', $id)
        ->first();

        $pdf = PDF::loadView('pdf.pengembalian', [
            'data' => $data,
        ], [ ], [
            'format' => 'A4-P'
        ]);

        return $pdf->stream('Pengembalian '. $data->nomor .'.pdf');
    }

    
    public function report(Request $request)
    {
        $tgl = explode(" - ",$request->tgl);
        $data = Pengembalian::whereBetween('tgl', $tgl)->get();
        $config = [
            'format' => 'A4-L' // Landscape
        ];

        $pdf = PDF::loadView('pdf.pengembalian_report', [
            'data' => $data,
            'tgl' =>$tgl
        ], [ ], $config);

        return $pdf->stream('Laporan Pengembalian.pdf');

    }
}
