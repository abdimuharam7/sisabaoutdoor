<x-layouts.app title="Katalog">
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            KATALOG SABA OUTDOOR
        </h2>
    </x-slot>
    <div class="grid grid-cols-5 gap-4 p-10">
        @foreach ($katalogs as $item)
        <div class="rounded-lg border bg-white overflow-hidden shadow-lg">
            <img src="{{ asset('uploads') }}/{{ $item->foto }}" class="h-52 w-full object-cover" alt="">
            <div class="p-3 space-y-1">
                <p class="line-clamp-1 font-bold capitalize cursor-pointer" data-modal-target="show-deskripsi-{{ $item->id }}" data-modal-toggle="show-deskripsi-{{ $item->id }}">{{ $item->nama }}</p>
                <x-modal.show-deskripsi :katalog="$item">

                </x-modal.show-deskripsi>
                <p>Rp. {{ number_format($item->harga,0,',','.') }}</p>
                <div class="flex justify-between">
                    <p class="text-xs">{{ $item->stok }} Stok Tersedia</p>
                    <p class="text-xs">{{ $item->satuan }}</p>
                </div>
                <form action="{{ route('keranjang.store', $item->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="katalog_id" value="{{ $item->id }}">
                    <button type="submit" {{ $item->stok ? '' : 'disabled="disabled"' }}  class="bg-green-500 rounded-lg text-white w-full py-1 disabled:bg-green-300 disabled:cursor-not-allowed">
                        Tambah Keranjang
                    </button>
                </form>
            </div>

        </div>
        @endforeach

    </div>
    
</x-layouts.app>
<script>
</script>