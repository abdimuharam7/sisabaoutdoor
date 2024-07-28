<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Data Pengadaan
        </h2>
    </x-slot>
    <div class="relative">
        
        <div class="min-w-full py-4 bg-white border border-gray-200 rounded-lg shadow">
            <div class="p-4 d-flex">
                
            <a href="{{ route('admin.pengadaan.create') }}" class="bg-green-500 text-white rounded-lg px-5 py-2">
                Tambah Pengadaan
            </a>
            </div>
            <table class="dataTable" width="100%">
                <thead class="bg-green-500 text-white">
                    <tr>
                        <td width="50px">No</td>
                        <td>Kode</td>
                        <td>Supplier</td>
                        <td>Tgl</td>
                        <td>Status</td>
                        <td>Total</td>
                        <td>Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pemesanan as $item)
                    <tr>
                        <td class>{{ $loop->index+1 }}</td>
                        <td>{{ $item->kode }}</td>
                        <td>{{ $item->supplier }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl)->translatedFormat('d F Y') }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            @php
                            $total = 0;
                            @endphp
                            @foreach ($item->item as $items)
                            @php
                                $total += $items->harga * $items->jumlah;
                            @endphp
                            @endforeach
                            <p> Rp. {{ number_format($total, 0, ',', '.') }}</p>
                        </td>
                        <td class="py-1 px-2">
                            <div class="flex gap-3 justify-center items-center">
                                <a href="{{ route('admin.pengadaan.edit', $item->id) }}" class="text-blue-500">Edit</a>
                                <form action="{{ route('admin.pengadaan.destroy', $item->id) }}" method="post">
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
    </div>

</x-app-layout>
<script>
    $(document).ready(function() {
        $('.dataTable').DataTable();
    })
</script>
