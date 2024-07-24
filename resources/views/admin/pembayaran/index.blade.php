<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Data Sewa
        </h2>
    </x-slot>
        <div class="relative">
            <a href="#" class="bg-green-500 text-white rounded-lg px-5 py-2"> Tambah Sewa</a>
            <table class="w-full dataTable">
                <thead class="bg-green-500 text-white">
                    <tr>
                        <td>No</td>
                        <td>Kode</td>
                        <td>Pelanggan</td>
                        <td>Tanggal Penyewaan</td>
                        <td>Durasi</td>
                        <td>Jaminan</td>
                        <td>Status</td>
                        <td>Jenis Pembayaran</td>
                        <td>Status Pembayaran</td>
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
                            <td>{{ $item->tgl_penyewaan }} {{ $item->jam_pengambilan }}</td>
                            <td>{{ $item->durasi }} Hari</td>
                            <td>{{ $item->jaminan}}</td>
                            <td>{{ $item->status_penyewaan }}</td>
                            <td>{{ $item->jenis_pembayaran }}</td>
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
                                <div class="flex gap-3 justify-center items-center">
                                    <a href="{{ route('pembayaran.edit', $item->id) }}" class="text-blue-500">Edit</a>
                                    <form action="{{ route('pembayaran.destroy', $item->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500">Hapus</button>

                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

</x-app-layout>
<script>
    $(document).ready(function() {
        $('.dataTable').DataTable({
            searching: true,
            info: false,
            lengthChange: false,
            paging: true
        });
    })
</script>
