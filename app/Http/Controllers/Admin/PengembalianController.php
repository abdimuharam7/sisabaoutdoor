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

        $pemesanan = Pemesanan::select('kode_transaksi as label', 'id as value')
        ->where('status_penyewaan', 'diterima')->get()->toArray();

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
        }

        return redirect()->back()->with(['success' => 'Berhasil Membuat Pesanan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemesanan  $pemesanan
     * @return \Illuminate\Http\Response
     */
    public function show(Pemesanan $pemesanan)
    {
        //
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
    public function update(Request $request, Pemesanan $pemesanan)
    {
    //    $request->validate([
    //        'status_penyewaan' => 'required|in:menunggu,disewa,selesai',
    //        'status_pembayaran' => 'required|in:menunggu,dibayar,dibatalkan',
    //    ]);

            $pemesanan->status_penyewaan = $request->status_penyewaan;
            $pemesanan->status_pembayaran = $request->status_pembayaran;
            $pemesanan->save();
           return redirect()->route('pemesanan.index')->with('success', 'Data pemesanan berhasil diperbarui.');
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

    public function userPesanan()
    {
        $pemesanan = Pemesanan::where('user_id', Auth::user()->id)->get();
        return view('pesanan', compact('pemesanan'));
    }
    public function userCheckout($kode)
    {
        $pemesanan = Pemesanan::where('kode_transaksi', $kode)->first();
        $duitkuConfig = new Config(env('DUITKU_API_KEY'), env('DUITKU_MERCHANT_KODE'));
        $response = Api::getPaymentMethod(2000000, $duitkuConfig);
        $jsonResponse = json_decode($response);
        $paymentMethod = collect($jsonResponse->paymentFee);
        return view('checkout', compact('pemesanan', 'paymentMethod'));
    }
    public function payment(Request $request, Pemesanan $pemesanan)
    {
        $duitkuConfig = new Config(env('DUITKU_API_KEY'), env('DUITKU_MERCHANT_KODE'));

        $items = [];
        $amount = 0;
        foreach ($pemesanan->item as $item) {
            $price = $item->katalog->harga * $pemesanan->durasi;
            $items[] = [
                'name' => $item->katalog->nama,
                'price' => $price*$item->jumlah,
                'quantity' => $item->jumlah,
            ];

            $amount += $price * $item->jumlah;
        }

        $params = array(
            'paymentAmount' => $amount,
            'paymentMethod' => $request->paymentMethod,
            'merchantOrderId' => $pemesanan->kode_transaksi,
            'productDetails' => 'Pembayaran Sewa Alat Outdoor',
            'customerVaName' => Auth::user()->nama,
            'email' => Auth::user()->email,
            'phoneNumber' => Auth::user()->nomor_wa,
            'itemDetails' => $items,
            'returnUrl' => route('payment.check',$pemesanan->kode_transaksi),
            'expiryPeriod' => 180,
        );
        try {
            $response = Api::createInvoice($params, $duitkuConfig);
            $json = json_decode($response);
            if (isset($json->paymentUrl)) {
                return Redirect::away($json->paymentUrl);
            } else {
                // Handle error response
                return back()->withErrors(['msg' => 'Failed to create payment invoice.']);
            }
        } catch (Exception $e) {
            // Handle exception
            if($e->getMessage() == 'Duitku Error: 400 response: {"Message":"Bill already paid"}'){
                $pemesanan->status_pembayaran = 'Dibayar';
                $pemesanan->save();
                return redirect()->route('user.pesanan');

            }
            dd($e->getMessage());
        }
    }
    public function paymentCheck($code)
    {
        $pemesanan = Pemesanan::where('kode_transaksi', $code)->first();
        $duitkuConfig = new Config(env('DUITKU_API_KEY'), env('DUITKU_MERCHANT_KODE'));
        $response = Api::transactionStatus($code,$duitkuConfig);
        $jsonResponse = json_decode($response);
        $status = $jsonResponse->statusMessage;
        if($status == 'PROCESS'){
            $pemesanan->status_pembayaran = 'Menunggu';
        }elseif($status == 'SUCCESS'){
            $pemesanan->status_pembayaran = 'Dibayar';
            foreach($pemesanan->item as $item)
            {
                $katalog = $item->katalog;
                $katalog->stok = $katalog->stok - $item->jumlah;
                $katalog->save();
            }
        }else{
            $pemesanan->status_pembayaran = 'gagal';
        }
        $pemesanan->save();
        return redirect()->route('user.pesanan');
    }
}
