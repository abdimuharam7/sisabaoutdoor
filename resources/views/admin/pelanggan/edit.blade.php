<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Edit Data Pengadaan
        </h2>
    </x-slot>
    <div class="relative">
        <div
            class="min-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <form method="POST" action="{{ route('admin.pelanggan.update',$pelanggan->id) }}">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-3">

                    <!-- Nama -->
                    <div>
                        <x-input-label for="nama" :value="__('Nama')" />
                        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama"
                            :value="$pelanggan->nama " required autofocus autocomplete="nama" />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <!-- Jenis kelamin -->
                    <div>
                        <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                        <select id="jenis_kelamin" name="jenis_kelamin"
                            class="block mt-1 w-full rounded-lg border-gray-300" required autofocus
                            autocomplete="jenis_kelamin">
                            <option {{ $pelanggan->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }} value="Laki-Laki"
                                {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki
                            </option>
                            <option {{ $pelanggan->jenis_kelamin == 'Perempuan' ? 'selected' : '' }} value="Perempuan"
                                {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                    </div>

                    <!-- Nomor WA -->
                    <div>
                        <x-input-label for="nomor_wa" :value="__('Nomor WA')" />
                        <x-text-input id="nomor_wa" class="block mt-1 w-full" type="text" name="nomor_wa"
                            :value="$pelanggan->nomor_wa" required autofocus autocomplete="nomor_wa" />
                        <x-input-error :messages="$errors->get('nomor_wa')" class="mt-2" />
                    </div>

                    <!-- Alamat KTP -->
                    <div>
                        <x-input-label for="alamat_ktp" :value="__('Alamat KTP')" />
                        <x-text-input id="alamat_ktp" class="block mt-1 w-full" type="text" name="alamat_ktp"
                            :value="$pelanggan->alamat_ktp" required autofocus autocomplete="alamat_ktp" />
                        <x-input-error :messages="$errors->get('alamat_ktp')" class="mt-2" />
                    </div>

                    <!-- Alamat Domisili -->
                    <div>
                        <x-input-label for="alamat_domisili" :value="__('Alamat Domisili')" />
                        <x-text-input id="alamat_domisili" class="block mt-1 w-full" type="text" name="alamat_domisili"
                            :value="$pelanggan->alamat_domisili" required autofocus autocomplete="alamat_domisili" />
                        <x-input-error :messages="$errors->get('alamat_domisili')" class="mt-2" />
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <x-input-label for="tgl_lahir" :value="__('Tanggal Lahir')" />
                        <x-text-input id="tgl_lahir" class="block mt-1 w-full" type="date" name="tgl_lahir"
                            :value="$pelanggan->tgl_lahir" required autofocus autocomplete="tgl_lahir" />
                        <x-input-error :messages="$errors->get('tgl_lahir')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="$pelanggan->email" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">

                        <x-primary-button class="ml-4">
                            {{ __('Simpan') }}
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
