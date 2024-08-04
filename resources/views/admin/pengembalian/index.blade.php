<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Data Pengembalian
        </h2>
    </x-slot>
    <div class="relative">

        <div class="min-w-full py-4 bg-white border border-gray-200 rounded-lg shadow">
            <div class="p-4 d-flex">

                <a href="{{ route('admin.pengembalian.create') }}" class="bg-green-500 text-white rounded-lg px-5 py-2">
                    Tambah Pengembalian
                </a>
            </div>
            <table class="dataTable" width="100%">
                <thead class="bg-green-500 text-white">
                    <tr>
                        <td width="50px">No</td>
                        <td>Kode</td>
                        <td>Kode Sewa</td>
                        <td>Tanggal</td>
                        <td>Telat</td>
                        <td>Status</td>
                        <td>Total Denda</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemesanan as $item)
                    <tr>
                        <td class>{{ $loop->index+1 }}</td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->pemesanan->kode_transaksi }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_penyewaan)->translatedFormat('d F Y') }}</td>
                        <td>{{ $item->telat }} Hari</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <p> Rp. {{ number_format($item->total, 0, ',', '.') }}</p>
                        </td>
                        <td class="py-1 px-2">
                            
                            <a href="{{ route('admin.pengembalian.show', $item->id) }}" class="bg-green-500 text-white rounded-lg px-5 py-2">
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
