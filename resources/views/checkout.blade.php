<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PILIH TUJUAN PEMBAYARAN') }}
        </h2>
    </x-slot>
    <form action="{{ route('user.payment',$pemesanan->id) }}" method="POST">
        @csrf
        @method('POST')
        <div class="flex w-full border p-3 mb-3">
            <input type="radio" value="Cash" name="paymentMethod" id="cashPayment">
            <img src="{{ asset('../gambar/cash.jpg') }}" class="h-12 w-12 object-contain mr-2" alt="">
            <label for="cashPayment" class="ml-2">CASH (TUNAI)</label>
        </div>
        <div class="grid grid-cols-3 gap-3">
            @foreach ($paymentMethod as $item)
                <div class="flex w-full border p-3">
                    <input type="radio" value="{{ $item->paymentMethod }}" name="paymentMethod">
                    <img src="{{ $item->paymentImage }}" class="h-12 w-12 object-contain mr-2" alt="">
                    <p>{{ $item->paymentName }}</p>
                </div>
            @endforeach
        </div>
        <div class="text-right">
            <button type="submit" class="bg-orange-600 text-white py-2 px-4 text-center m-3 no-underline inline-block rounded-full">BAYAR SEKARANG</button>
        </div>
    </form>
</x-layouts.app>
