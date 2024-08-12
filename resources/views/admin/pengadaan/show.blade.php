<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Detail Pembelian
        </h2>
    </x-slot>
    <div class="relative">

        <div class="min-w-full py-4 bg-white border border-gray-200 rounded-lg shadow">
            <div class="px-4 pb-4 grid grid-cols-2 gap-3">
                <div class="flex">
                    <a href="{{ route('admin.pengadaan.edit', $data->id) }}" class="bg-green-500 mx-3 me-3 text-white rounded-lg px-5 py-2">
                        Ubah
                    </a>
                    <form action="{{ route('admin.pengadaan.destroy', $data->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white rounded-lg px-5 py-2">Hapus</button>
    
                    </form>
                </div>
                <div class="flex justify-end">
                    @if ($data->status == 'pending')
                    <button data-modal-target="alertSukses" data-modal-toggle="alertSukses" class="block me-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        Setuju
                    </button>
                    <button data-modal-target="alertTolak" data-modal-toggle="alertSukses" class="block ms-3 text-white bg-red-500 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-500 dark:focus:ring-red-800" type="button">
                        Tolak
                    </button>
                    @elseif ($data->status == 'disetujui')
                    <button data-modal-target="alertTerima" data-modal-toggle="alertTerima" class="block me-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        Terima
                    </button>

                    @endif

                </div>
            </div>
            <div class="p-4 grid grid-cols-2 gap-3">
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Tanggal</p>
                    <p>:</p>
                    <p>{{ \Carbon\Carbon::parse($data->tgl)->translatedFormat('d F Y') }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Status</p>
                    <p>:</p>
                    <p>{{ $data->supplier }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Status</p>
                    <p>:</p>
                    <p>{{ ucwords($data->status) }}</p>
                </div>
            </div>
            
            <table id="table-detail" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="divide-x divide-gray-200">
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                            Produk
                        </th>
                        <th width="70px" scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                            Stok
                        </th>
                        <th width="70px" scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                            Jumlah
                        </th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                            Harga Beli
                        </th>
                        <th width="250px" scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
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
                        <td>{{ $item->katalog->stok }}</td>
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
    <x-alert-modal msg="Setuju pengajuan pengadaan?" id="alertSukses" route="{{ route('admin.pengadaan.status', $data->id) }}" value="disetujui"/>
    <x-alert-modal msg="Tolak pengajuan pengadaan?" id="alertTolak" route="{{ route('admin.pengadaan.status', $data->id) }}" value="ditolak"/>
    <x-alert-modal msg="Produk telah datang?" id="alertTerima" route="{{ route('admin.pengadaan.status', $data->id) }}" value="diterima"/>

</x-app-layout>
<script>
    $(document).ready(function() {
        $('.dataTable').DataTable();
    })
</script>
