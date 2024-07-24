<?php

namespace App\Http\Controllers;

use App\Models\ItemPemesanan;
use App\Models\Katalog;
use App\Models\Pemesanan;
use Duitku\Api;
use Duitku\Config;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $date = strtotime(date("Y-m-d H:i:s"));
        $kode = IdGenerator::generate(['table' => 'pemesanans', 'field' => 'kode_transaksi', 'length' => 17, 'prefix' => 'TRX-' . $date]);
        $pemesanan = new Pemesanan();
        $pemesanan->kode_transaksi = $kode;
        $pemesanan->tgl_penyewaan = $request->tgl_penyewaan;
        $pemesanan->durasi = $request->durasi;
        $pemesanan->jam_pengambilan = $request->jam_pengambilan;
        $pemesanan->jaminan = $request->jaminan;
        $pemesanan->user_id = Auth::user()->id;
        $pemesanan->save();


        foreach ($request->item as $item) {
            $itemPesanan = new ItemPemesanan();
            $itemPesanan->katalog_id = $item['id'];
            $itemPesanan->pemesanan_id = $pemesanan->id;
            $itemPesanan->jumlah = $item['jumlah'];
            $itemPesanan->save();
        }

        foreach (Auth::user()->cart as $cart) {
            $cart->delete();
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
    public function edit(Pemesanan $pemesanan)
    {
       return view('admin.pembayaran.edit', compact('pemesanan'));
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
   // public function destroy(Pemesanan $pemesanan)
   // {
      //  $pemesanan->delete();

    //    return redirect()->route('pembayaran.index')->with('succes', 'data berhasil dihapus');
  //  }

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
