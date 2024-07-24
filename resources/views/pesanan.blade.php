<x-layouts.app>
    <div class="container mx-auto p-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($pemesanan as $item)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-2">Kode Transaksi: {{ $item->kode_transaksi }}</h2>
                    <p class="text-gray-600">Total: {{ $item->ItemPemesanan }}</p>
                </div>
                <div class="bg-gray-100 p-4">
                    <a href="{{ route('user.checkout', $item->kode_transaksi) }}" class="bg-orange-600 text-white py-2 px-4 text-center no-underline inline-block rounded-full w-full text-lg font-semibold">BAYAR</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-layouts.app>
