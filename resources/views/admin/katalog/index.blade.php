<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Data Katalog Saba
        </h2>
    </x-slot>
    <div class="relative">
        <div class="min-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

            <div class="p-4 d-flex">
            <a href="{{ route('admin.katalog.create') }}" class="bg-green-500 text-white rounded-lg px-5 py-2"> Tambah Katalog</a>
            </div>
            <div class>
            <table class="w-full dataTable">
                <thead class="bg-green-500 text-white">
                    <tr>
                        <td class="py-1 px-2 text-center">No</td>
                        <td class="py-1 px-2 text-center">Nama</td>
                        <td class="py-1 px-2 text-center">Harga</td>
                        <td class="py-1 px-2 text-center">Stok</td>
                        <td class="py-1 px-2 text-center">Foto</td>
                        <td class="py-1 px-2 text-center">Aksi</td>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($katalog as $item)
                        <tr>
                            <td class="py-1 px-2 text-center">{{ $loop->index + 1 }}</td>
                            <td class="py-1 px-2 text-center">{{ $item->nama }}</td>
                            <td class="py-1 px-2 text-center">{{ $item->harga }}</td>
                            <td class="py-1 px-2 text-center">{{ $item->stok }}</td>
                            <td class="py-1 px-2 text-center">
                                <div class ="flex justify-center">
                                    <img src="{{ asset('uploads') }}/{{ $item->foto }}" class="h-20" alt="">
                                </div>
                            </td>
                            <td class="py-1 px-2">
                                <div class="flex gap-3 justify-center items-center">
                                    <a href="{{ route('admin.katalog.edit', $item->id) }}" class="text-blue-500">Edit</a>
                                    <form action="{{ route('admin.katalog.destroy', $item->id) }}" method="post">
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
            <table class="w-full">
                <tfoot class="bg-orange-600 text-white">
                    <tr>
                        <td colspan="3" class="text-right font-bold">Total Jenis Alat:</td>
                        <td class="py-1 px-2 text-center font-bold">{{ $katalog->count() }}</td>
                        <td colspan="2" class="text-right font-bold">Jumlah Total Alat:</td>
                        <td class="py-1 px-2 text-center font-bold">
                            @php
                                $totalAlat = $katalog->sum('stok');
                            @endphp
                            {{ $totalAlat }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        $('.dataTable').DataTable();
    })
</script>
