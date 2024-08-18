<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Detail Pengembalian
        </h2>
    </x-slot>
    <div class="relative">

        <div class="min-w-full py-4 bg-white border border-gray-200 rounded-lg shadow">
            <div class="p-4 w-full flex flex-grow items-center justify-between">
                <div class="flex">
                    <a href="{{ route('admin.pengembalian.pdf', $data->id) }}" class="bg-green-500 me-3 text-white rounded-lg px-5 py-2">
                        Surat Pengembalian
                    </a>
                    <a href="{{ route('admin.pengembalian.edit', $data->id) }}" class="bg-green-500 me-3 text-white rounded-lg px-5 py-2">
                        Ubah
                    </a>
                    <form action="{{ route('admin.pengembalian.destroy', $data->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white rounded-lg px-5 py-2">Hapus</button>
    
                    </form>
                </div>
            </div>
            <div class="p-4 grid grid-cols-2 gap-3">
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Kode Pengembalian</p>
                    <p>:</p>
                    <p>{{ $data->kode }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">No Sewa</p>
                    <p>:</p>
                    <p>{{ $data->pemesanan->kode_transaksi }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Tanggal Pengembalian</p>
                    <p>:</p>
                    <p>{{ \Carbon\Carbon::parse($data->tgl)->translatedFormat('d F Y H:i') }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Keterlambatan</p>
                    <p>:</p>
                    <p>{{ $data->telat }}</p>
                </div>
            </div>
            
            <table id="table-detail" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="divide-x divide-gray-200">
                        <th scope="col" rowspan="2" class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase">
                            Produk
                        </th>
                        <th width="70px" rowspan="2" scope="col" class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase">
                            Jumlah
                        </th>
                        <th colspan="3" scope="col" class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase">
                            Kerusakan
                        </th>
                        <th scope="col" width="70px" rowspan="2" class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase">
                            Kehilangan
                        </th>
                        <th scope="col" rowspan="2" class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase">
                            Denda
                        </th>
                    </tr>
                    <tr class="divide-x divide-y divide-gray-300">
                        <th scope="col" width="70px" class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase">
                            Ringan 10%
                        </th>
                        <th scope="col" width="70px" class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase">
                            Sedang 25%
                        </th>
                        <th scope="col" width="70px" class="px-6 py-3 text-center text-sm font-medium text-gray-500 uppercase">
                            Total 50%
                        </th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($data->denda as $d)
                    
                    @php
                        $total = $d->total;
                    @endphp

                        <tr class="divide-x divide-y divide-gray-300">
                            <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-800 dark:text-neutral-200">
                                {{ $d->katalog->nama }}<br />
                                Rp. {{ number_format($d->katalog->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                {{ $d->pesanan->qty  ?? 0}}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                {{ $d->rusak_ringan  ?? 0}}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                {{ $d->rusak_sedang  ?? 0}}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                {{ $d->rusak_total  ?? 0}}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                {{ $d->hilang  ?? 0}}
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <span class="showDenda">{{ $total }}</span>
                            </td>
                        </tr>
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
