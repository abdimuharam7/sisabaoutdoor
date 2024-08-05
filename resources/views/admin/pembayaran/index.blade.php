<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Data Sewa
        </h2>
    </x-slot>
    <div class="relative">
        
        <div class="min-w-full py-4 bg-white border border-gray-200 rounded-lg shadow">
            <div class="p-4 d-flex">
                
            <a href="{{ route('admin.pemesanan.create') }}" class="bg-green-500 text-white rounded-lg px-5 py-2"> Tambah
                Sewa</a>
            </div>
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
                            
                            <a href="{{ route('admin.pemesanan.show', $item->id) }}" class="bg-green-500 text-white rounded-lg px-5 py-2">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-app-layout>
<script>
    $(document).ready(function() {
        $('.dataTable').DataTable();
    })
</script>
