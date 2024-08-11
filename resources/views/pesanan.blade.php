<x-layouts.app>
    <div class="container mx-auto p-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
            @foreach ($pemesanan as $item)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-2">Kode Transaksi: {{ $item->kode_transaksi }}</h2>
                    {{-- <p class="text-gray-600">KET: {{ $item }}</p>  --}}
                    <div class="flex gap-1">
                        <p class="w-48 flex-none fs-sm">Tanggal Sewa</p>
                        <p>:</p>
                        <p>{{ \Carbon\Carbon::parse($item->tgl_penyewaan)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div class="flex gap-1">
                        <p class="w-48 flex-none fs-sm">Durasi</p>
                        <p>:</p>
                        <p>{{ $item->durasi }} Hari</p>
                    </div>
                    <div class="flex gap-1">
                        <p class="w-48 flex-none fs-sm">Waktu Pengambilan</p>
                        <p>:</p>
                        <p>{{ \Carbon\Carbon::parse($item->jam_pengambilan)->translatedFormat('H:i') }}</p>
                    </div>
                    <div class="flex gap-1">
                        <p class="w-48 flex-none fs-sm">Status Penyewaan</p>
                        <p>:</p>
                        <p>{{ $item->status_penyewaan }}</p>
                    </div>
                    <div class="flex gap-1">
                        <p class="w-48 flex-none fs-sm">Status Pembayaran</p>
                        <p>:</p>
                        <p>{{ $item->status_pembayaran }}</p>
                    </div>
                </div>
                <div class="bg-gray-100 p-4">
                    <a href="{{ route('user.checkout', $item->kode_transaksi) }}" class="bg-orange-600 text-white py-2 px-4 text-center no-underline inline-block rounded-full w-full text-lg font-semibold">BAYAR</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>
