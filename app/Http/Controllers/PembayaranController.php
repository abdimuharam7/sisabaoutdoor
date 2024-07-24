<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    //
    public function index()
    {

    }

    public function edit(Pemesanan $pemesanan)
    {
    }

    public function update(Request $request, Pemesanan $pemesanan)
    {
        // Validasi input
        $request->validate([
            'status_penyewaan' => 'required|in:menunggu,disewa,selesai',
            'status_pembayaran' => 'required|in:menunggu,dibayar,dibatalkan',
        ]);

        // Update data pemesanan
        $pemesanan->update([
            'status_penyewaan' => $request->input('status_penyewaan'),
            'status_pembayaran' => $request->input('status_pembayaran'),
        ]);

        $pemesanan->status_penyewaan = $request->status_penyewaan;
        $pemesanan->status_pembayaran = $request->status_pembayaran;
        $pemesanan->save();

        // Redirect ke halaman daftar pemesanan dengan pesan sukses
        return redirect()->route('admin.pembayaran.index')->with('success', 'Data pemesanan berhasil diperbarui.');
    }

    public function destroy(Pemesanan $pemesanan)
    {
        $pemesanan->delete();

        return redirect()->route('pembayaran.index')->with('succes', 'data berhasil dihapus');
    }
}
