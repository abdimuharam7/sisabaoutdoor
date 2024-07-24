<!-- resources/views/admin/katalog/index.blade.php -->
<x-app-layout>
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Kelola Katalog</h1>

        <form action="{{ route('katalogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="nama" id="nama" class="mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                <input type="decimal" name="harga" id="harga" class="mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="string" name="jumlah" id="jumlah" class="mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="foto" class="block text-sm font-medium text-gray-700">Foto</label>
                <input type="file" name="foto" id="foto" class="mt-1 block w-full">
            </div>
            <div class="mb-4">
                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="mt-1 block w-full"></textarea>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Tambah Katalog</button>
        </form>

        <h2 class="text-xl font-bold mt-8">Daftar Katalog</h2>
        <div class="mt-4">
            @foreach ($katalogs as $katalog)
                <div class="border p-4 mb-4">
                    @if ($katalog->foto)
                        <img src="{{ asset('storage/' . $katalog->foto) }}" alt="{{ $katalog->nama }}" width="100">
                    @endif
                    <h3 class="text-lg font-bold">{{ $katalog->nama }}</h3>
                    <p>Harga: {{ $katalog->harga }}</p>
                    <p>{{ $katalog->keterangan }}</p>
                    <form action="{{ route('katalogs.destroy', $katalog->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded">Hapus</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
