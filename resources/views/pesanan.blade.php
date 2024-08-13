<x-layouts.app>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi') }}
        </h2>
    </x-slot>
    <div class="relative pt-7">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg">
                
            <table class="dataTable" width="100%">
                <thead class="bg-green-500 text-white">
                    <tr>
                        <td width="50px">No</td>
                        <td>Kode</td>
                        <td>Pelanggan</td>
                        <td>Tgl Sewa</td>
                        <td>Durasi</td>
                        <td>Status</td>
                        <td>Pembayaran</td>
                        <td>Total</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemesanan as $item)
                    <tr>
                        <td class>{{ $loop->index+1 }}</td>
                        <td>{{ $item->kode_transaksi }}</td>
                        <td>{{ $item->user->nama }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_penyewaan)->translatedFormat('d F Y') }}</td>
                        <td>{{ $item->durasi }} Hari</td>
                        <td>{{ $item->status_penyewaan }}</td>
                        <td>{{ $item->status_pembayaran }}</td>
                        <td>
                            @php
                            $total = 0;
                            @endphp
                            @foreach ($item->item as $items)
                            @php
                            $total += $items->katalog->harga * $items->jumlah;
                            @endphp
                            @endforeach
                            <p> Rp. {{ number_format($total, 0, ',', '.') }}</p>
                        </td>
                        <td class="py-1 px-2">

                            <a href="{{ route('user.pesanan.show', $item->id) }}"
                                class="bg-green-500 text-white rounded-lg px-5 py-2">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable();
        })
    </script>
    @endpush
</x-layouts.app>
