<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Edit Katalog
        </h2>
    </x-slot>
    <div class="relative">
        
        <div class="min-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <form method="POST" action="{{ route('admin.katalog.update', $katalog->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-2 gap-3">

                    <div class="mb-2">
                        <x-input-label for="nama" :value="__('Nama')" />
                        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama', $katalog->nama)" required autofocus autocomplete="nama" />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>
                    <div class="mb-2">
                        <x-input-label for="satuan" :value="__('Satuan')" />
                        <x-text-input id="satuan" class="block mt-1 w-full" type="text" name="satuan" :value="old('satuan', $katalog->satuan)" required autofocus autocomplete="satuan" />
                        <x-input-error :messages="$errors->get('satuan')" class="mt-2" />
                    </div>
                    <div class="mb-2">
                        <x-input-label for="harga" :value="__('Harga Sewa')" />
                        <x-text-input id="harga" class="block mt-1 w-full" type="number" step="0.01" name="harga" :value="old('harga', $katalog->harga)" required autofocus autocomplete="harga" />
                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                    </div>
                    <div class="mb-2">
                        <x-input-label for="harga_beli" :value="__('Harga Beli')" />
                        <x-text-input id="harga_beli" class="block mt-1 w-full" type="number" step="0.01" name="harga_beli" :value="old('harga_beli', $katalog->harga_beli)" required autofocus autocomplete="harga_beli" />
                        <x-input-error :messages="$errors->get('harga_beli')" class="mt-2" />
                    </div>
                    <div class="mb-2">
                        
                    <x-input-label for="stok" :value="__('Stok')" />
                    <x-text-input id="stok" class="block mt-1 w-full" type="number" name="stok" :value="old('stok', $katalog->stok)" required autofocus autocomplete="stok" />
                    <x-input-error :messages="$errors->get('stok')" class="mt-2" />
                    </div>
                    <div class="mb-2">
                        
                    <x-input-label for="foto" :value="__('Foto')" />
                    <input type="file" id="foto" name="foto" class="block mt-1 w-full rounded-lg border-gray-300">
                    <x-input-error :messages="$errors->get('foto')" class="mt-2" />
                    </div>
                </div>
                <div class="mb-2">
                    
                    <x-input-label for="stok" :value="__('Deskripsi')" />
                    <textarea name="deskripsi" id="deskripsi" rows="10" class="block mt-1 w-full rounded-lg border-gray-300">{{ old('deskripsi', $katalog->deskripsi) }}</textarea>
                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                </div>

                <x-primary-button class="ml-4">
                    {{ __('Simpan') }}
                </x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
