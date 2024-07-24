<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Edit Data Sewa
        </h2>
    </x-slot>
    <div class="p-10">
        <form method="POST" action="{{ route('pemesanan.update', $pemesanan->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-3">
                {{ $pemesanan }}
                <select name="status_penyewaan" id="">
                    <option value="" disabled selected> Pilih Status Penyewaan</option>
                    <option {{ $pemesanan->status_penyewaan == 'Menunggu' ? 'selected':'' }} value="Menunggu">Menunggu</option>
                    <option {{ $pemesanan->status_penyewaan == 'Diterima' ? 'selected':'' }} value="Diterima">Diterima</option>
                    <option {{ $pemesanan->status_penyewaan == 'Ditolak' ? 'selected':'' }} value="Ditolak">Ditolak</option>
                </select>
                <select name="status_pembayaran" id="">
                    <option value="" disabled selected> Pilih Status Pembayaran</option>
                    <option {{ $pemesanan->status_pembayaran == 'Menunggu' ?'selected':'' }} value="Menunggu">Menunggu</option>
                    <option {{ $pemesanan->status_pembayaran == 'Dibayar' ?'selected':'' }} value="Dibayar">Dibayar</option>
                    <option {{ $pemesanan->status_pembayaran == 'gagal' ?'selected':'' }} value="gagal">Gagal</option>
                </select>
                <button type="submit">simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
