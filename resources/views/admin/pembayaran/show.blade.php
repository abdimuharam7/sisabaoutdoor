<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Detail Pesanan
        </h2>
    </x-slot>
    <div class="relative">

        <div class="min-w-full py-4 bg-white border border-gray-200 rounded-lg shadow">
            <div class="px-4 pb-4 grid grid-cols-2 gap-3">
                <div>
                    <a href="{{ route('admin.pemesanan.pdf', ['id' => $data->id, 'type' => 'invoice']) }}" class="bg-green-500 me-3 text-white rounded-lg px-5 py-2">
                        Invoice
                    </a>
                    <a href="{{ route('admin.pemesanan.pdf', ['id' => $data->id, 'type' => 'bukti']) }}" class="bg-green-500 me-3 text-white rounded-lg px-5 py-2">
                        Bukti Terima Barang
                    </a>
                </div>
                <div class="flex justify-end">
                    @if ($data->status_pembayaran == 'Menunggu')
                    <button data-modal-target="alertSukses" data-modal-toggle="alertSukses" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        Konfirmasi Pembayaran
                    </button>
                    @endif

                    <a href="{{ route('admin.pemesanan.edit', $data->id) }}" class="bg-green-500 mx-3 me-3 text-white rounded-lg px-5 py-2">
                        Ubah
                    </a>
                    <form action="{{ route('admin.pemesanan.destroy', $data->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white rounded-lg px-5 py-2">Hapus</button>
    
                    </form>
                </div>
            </div>
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
                    <p class="w-48 flex-none">Status Penyewaan</p>
                    <p>:</p>
                    <p>{{ $data->status_penyewaan }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Status Pembayaran</p>
                    <p>:</p>
                    <p>{{ $data->status_pembayaran }}</p>
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
    <x-alert-modal id="alertSukses" msg="Konfirmasi Pembayaran?" route="{{ route('admin.pemesanan.bayar', $data->id) }}" value="Dibayar"/>
</x-app-layout>
<script>
    $(document).ready(function() {
        $('.dataTable').DataTable();
    })
</script>
