<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Detail Pesanan
        </h2>
    </x-slot>
    <div class="relative">

        <div class="min-w-full py-4 bg-white border border-gray-200 rounded-lg shadow">
            <div class="p-4 w-full flex flex-grow items-center justify-between">
                <div class="flex">
                    <a href="{{ route('admin.pemesanan.pdf', $data->id) }}" class="bg-green-500 me-3 text-white rounded-lg px-5 py-2">
                        Invoice
                    </a>
                    <a href="{{ route('admin.pemesanan.edit', $data->id) }}" class="bg-green-500 me-3 text-white rounded-lg px-5 py-2">
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
                    $i = 0;
                    @endphp
                    @foreach ($data->item as $item)
                    <tr class="row-{{ $i }}">
                        <td>{{ $item->katalog->nama }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>{{ $item->katalog->harga }}</td>
                        <td>{{ $item->katalog->harga * $item->jumlah }}</td>
                    </tr>
                    @php
                    $i++;
                    @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6"
                            class="dark:text-neutral-200 font-bold px-3 py-2 text-end text-gray-800 text-lg whitespace-nowrap">
                            Total Denda
                        </td>
                        <td 
                            class="dark:text-neutral-200 font-bold px-3 py-2 text-end text-gray-800 text-lg whitespace-nowrap">
                            <span class="showTotal">Rp. 0</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</x-app-layout>
<script>
    $(document).ready(function() {
        $('.dataTable').DataTable();
    })
</script>
