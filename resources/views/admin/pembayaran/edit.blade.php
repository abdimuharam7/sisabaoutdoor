<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Edit Data Sewa
        </h2>
    </x-slot>
    <div class="p-10">
        <form method="POST" action="{{ route('pembayaran.update', $pemesanan->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-3">

                <div>
                    <x-input-label for="koded" :value="__('Nama')" />
                    <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama', $pembayaran->nama)" required autofocus autocomplete="nama" />
                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="nama" :value="__('Nama')" />
                    <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama', $pembayaran->nama)" required autofocus autocomplete="nama" />
                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>

                <div class="text-right">
                    <x-primary-button class="ml-4">
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
