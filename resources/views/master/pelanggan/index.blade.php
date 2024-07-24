<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Data Pelanggan
        </h2>
    </x-slot>
        <div class="relative space-y-5">
            <a href="{{ route('pelanggan.create') }}" class="bg-green-500 text-white rounded-lg px-5 py-2"> Tambah Pelanggan</a>
            <div class>
                <table class="w-full dataTable">
                    <thead class="bg-green-500 text-white">
                        <tr>
                            <td class="py-1 px-2 text-center">No</td>
                            <td class="py-1 px-2 text-center">Nama</td>
                            <td class="py-1 px-2 text-center">Email</td>
                            <td class="py-1 px-2 text-center">No Wa</td>
                            <td class="py-1 px-2 text-center">Alamat KTP</td>
                            <td class="py-1 px-2 text-center">Domisili</td>
                            <td class="py-1 px-2 text-center">Tgl Lahir</td>
                            <td class="py-1 px-2 text-center">Aksi</td>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($pelanggan as $item)
                        <tr>
                            <td class="py-1 px-2 text-center">{{ $loop->index +1 }}</td>
                            <td class="py-1 px-2 text-center">{{ $item->nama }}</td>
                            <td class="py-1 px-2 text-center">{{ $item->email }}</td>
                            <td class="py-1 px-2 text-center">{{ $item->nomor_wa }}</td>
                            <td class="py-1 px-2 text-center">{{ $item->alamat_ktp }}</td>
                            <td class="py-1 px-2 text-center">{{ $item->alamat_domisili }}</td>
                            <td class="py-1 px-2 text-center">{{ $item->tgl_lahir }}</td>
                            <td class="py-1 px-2 text-center">
                                <div class="flex gap-3 justify-center items-center">
                                    <a href="{{ route('pelanggan.edit', $item->id) }}" class="text-blue-500">Edit</a>
                                    <form action="{{ route('pelanggan.destroy', $item->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500">Hapus</button>

                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-orange-600 text-white">
                        <tr>
                            <td colspan="7" class="text-right font-bold">Total Akun Pelanggan:</td>
                            <td class="py-1 px-2 text-center font-bold">{{ $pelanggan->count() }} Orang </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        $('.dataTable').DataTable({
            searching: true,
            info: false,
            lengthChange: false,
            paging: true,
        });
    })
</script>
