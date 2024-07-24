<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Kelola Katalog
        </h2>
    </x-slot>
    <div class>
        <form method="POST" action="{{ route('katalog.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="container mx-auto px-4">
                <!-- Nama -->
                <div>
                    <x-input-label for="nama" :value="__('Nama')" />
                    <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required autofocus autocomplete="nama" />
                    <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                </div>

                 <!-- Harga -->
                 <div>
                    <x-input-label for="harga" :value="__('Harga')" />
                    <x-text-input id="harga" class="block mt-1 w-full" type="number" step="0.01" name="harga" :value="old('harga')" required autofocus autocomplete="harga" />
                    <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                </div>

                <!-- Stok -->
                <div>
                    <x-input-label for="stok" :value="__('Stok')" />
                    <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok" :value="old('stok')" required autofocus autocomplete="stok" />
                    <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                </div>

                 <!-- Foto -->
                 <div>
                    <x-input-label for="foto" :value="__('Foto')" />
                    <input type="file" id="foto" name="foto" class="block mt-1 w-full rounded-lg border-gray-300">
                    <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                </div>

                 <!-- Deskripsi -->
                 <div>
                    <x-input-label for="stok" :value="__('Deskripsi')" />
                    <textarea name="deskripsi" id="deskripsi" rows="10" class="block mt-1 w-full rounded-lg border-gray-300"></textarea>
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Simpan') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
