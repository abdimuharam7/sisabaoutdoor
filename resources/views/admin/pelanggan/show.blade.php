<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Detail Pelanggan
        </h2>
    </x-slot>
    <div class="relative">

        <div class="min-w-full py-4 bg-white border border-gray-200 rounded-lg shadow">
            <div class="px-4 pb-4 grid grid-cols-2 gap-3">
                <div class="flex">
                    <a href="{{ route('admin.pelanggan.edit', $data->id) }}" class="bg-green-500 mx-3 me-3 text-white rounded-lg px-5 py-2">
                        Ubah
                    </a>
                    <form action="{{ route('admin.pelanggan.destroy', $data->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white rounded-lg px-5 py-2">Hapus</button>
    
                    </form>
                </div>
                <div class="flex justify-end">

                </div>
            </div>
            <div class="p-4 grid grid-cols-2 gap-3">
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Nama Lengkap</p>
                    <p>:</p>
                    <p>{{ $data->nama }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Jenis Kelamin</p>
                    <p>:</p>
                    <p>{{ $data->jenis_kelamin }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Tanggal Lahir</p>
                    <p>:</p>
                    <p>{{ \Carbon\Carbon::parse($data->tgl_lahir)->translatedFormat('d F Y') }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Nomor WA</p>
                    <p>:</p>
                    <p>{{ $data->nomor_wa }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Email</p>
                    <p>:</p>
                    <p>{{ $data->email }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">File KTP</p>
                    <p>:</p>
                    <p>
                        <a href="{{ $data->ktp }}" class="bg-green-500 text-white rounded-lg px-5 py-2">
                        Lihat File
                        </a>
                    </p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Alamat KTP</p>
                    <p>:</p>
                    <p>{{ $data->alamat_ktp }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-48 flex-none">Alamat Domisili</p>
                    <p>:</p>
                    <p>{{ $data->alamat_domisili }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    $(document).ready(function() {
        $('.dataTable').DataTable();
    })
</script>
