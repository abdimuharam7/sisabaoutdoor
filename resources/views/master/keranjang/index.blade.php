<x-layouts.app>
    <div class="">
        <form action="{{ route('pemesanan.store') }}" method="POST">
            @csrf
            @method('POST')
            <ul class="space-y-3 p-10 max-w-2xl mx-auto">
                @foreach ($cart as $item)
                    <li>
                        <div class="bg-white rounded-lg border py-3 px-10 grid grid-cols-3 ">
                            <div class="h-full w-full flex items-start flex-col justify-center">
                                <img src="{{ asset('uploads/') }}/{{ $item->katalog->foto }}" class=" h-20 object-cover" alt="">
                                <p>
                                    {{ $item->katalog->nama }}
                                </p>
                            </div>
                            <div class="flex gap-3 items-center justify-center">
                                <button type="button">-</button>
                                <input value="{{ $item->jumlah }}" type="number" class="w-12 rounded-lg h-min" name="item[{{ $item->id }}][jumlah]" id="">
                                <input value="{{ $item->katalog->id }}" type="hidden" name="item[{{ $item->id }}][id]" id="">
                                <button type="button">+</button>
                            </div>
                            <p class="text-end">{{ $item->katalog->harga }}</p>
                        </div>
                    </li>
                @endforeach
                <li>
                    <button data-modal-target="tambah-pemesanan" data-modal-toggle="tambah-pemesanan" type="button" class="py-1 text-center bg-green-500 text-white w-full rounded-lg hover:bg-opacity-90">Pesan Sekarang</button>
                    <x-modal.tambah-pemesanan></x-modal.tambah-pemesanan>
                </li>
            </ul>
        </form>
    </div>
</x-layouts.app>
