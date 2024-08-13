<x-layouts.app>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pesanan
        </h2>
    </x-slot>
    <div class="relative pt-7">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg">
                @if($data->status_pembayaran == 'Menunggu')
                <div class="p-4 text-center">
                    <h3 class="text-xl mb-3">Selesaikan Pembayaran</h3>
                    <a href="{{ route('user.checkout', $data->kode_transaksi) }}" class="bg-green-500 mx-3 me-3 text-white rounded-lg px-5 py-2">
                        Bayar Sekarang
                    </a>
                </div>
    
                @elseif($data->status_pembayaran == 'gagal')
                @endif
                <div class="p-4 grid grid-cols-2 gap-3">
                    <div class="flex gap-1">
                        <p class="w-48 flex-none">Pelanggan</p>
                        <p>:</p>
                        <p>{{ $data->user->nama }}</p>
                    </div>
                    <div class="flex gap-1">
                        <p class="w-48 flex-none">No Sewa</p>
                        <p>:</p>
                        <p>{{ $data->kode_transaksi }}</p>
                    </div>
                    <div class="flex gap-1">
                        <p class="w-48 flex-none">Tanggal Sewa</p>
                        <p>:</p>
                        <p>{{ \Carbon\Carbon::parse($data->tgl_penyewaan)->translatedFormat('d F Y') }}</p>
                    </div>
                    <div class="flex gap-1">
                        <p class="w-48 flex-none">Waktu Pengambilan</p>
                        <p>:</p>
                        <p>{{ \Carbon\Carbon::parse($data->jam_pengambilan)->translatedFormat('H:i') }} WIB</p>
                    </div>
                    <div class="flex gap-1">
                        <p class="w-48 flex-none">Lama Sewa</p>
                        <p>:</p>
                        <p>{{ $data->durasi }} Hari</p>
                    </div>
                    <div class="flex gap-1">
                        <p class="w-48 flex-none">Status</p>
                        <p>:</p>
                        <p>{{ $data->status_penyewaan }}</p>
                    </div>
                </div>
                
                <table id="table-detail" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="divide-x divide-gray-200">
                            <th>
                                Produk
                            </th>
                            <th width="70px" scope="col">
                                Jumlah
                            </th>
                            <th scope="col">
                                Harga
                            </th>
                            <th scope="col">
                                Subtotal
                            </th>
                        </tr>
                    </thead>
                    
                    
                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                        @php
                        $total = 0;
                        @endphp
                        @foreach ($data->item as $item)
                        <tr class="row-{{ $loop->index }}">
                            <td>{{ $item->katalog->nama }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp. {{ number_format($item->katalog->harga,0,',','.') }}</td>
                            <td>Rp. {{ number_format($item->katalog->harga* $item->jumlah,0,',','.') }}</td>
                        </tr>
                        @php
                            $total +=  $item->katalog->harga* $item->jumlah;
                        @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"
                                class="dark:text-neutral-200 font-bold px-3 py-2 text-end text-gray-800 text-lg whitespace-nowrap">
                                Total
                            </td>
                            <td 
                                class="dark:text-neutral-200 font-bold px-3 py-2 text-end text-gray-800 text-lg whitespace-nowrap">
                                <span class="showTotal">Rp. {{ number_format($total,0,',','.') }}</span>
                            </td>
                        </tr>
                    </tfoot>
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
