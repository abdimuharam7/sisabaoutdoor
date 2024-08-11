<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-2 gap-3">

            <!-- Nama -->
            <div>
                <x-input-label for="nama" :value="__('Nama')" />
                <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" required
                    autofocus autocomplete="nama" />
                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
            </div>

            <!-- Jenis kelamin -->
            <div>
                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full rounded-lg border-gray-300"
                    required autofocus autocomplete="jenis_kelamin">
                    <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki
                    </option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
            </div>

            <!-- Nomor WA -->
            <div>
                <x-input-label for="nomor_wa" :value="__('Nomor WA')" />
                <x-text-input id="nomor_wa" class="block mt-1 w-full" type="text" name="nomor_wa"
                    :value="old('nomor_wa')" required autofocus autocomplete="nomor_wa" />
                <x-input-error :messages="$errors->get('nomor_wa')" class="mt-2" />
            </div>

            <!-- Alamat KTP -->
            <div>
                <x-input-label for="alamat_ktp" :value="__('Alamat KTP')" />
                <x-text-input id="alamat_ktp" class="block mt-1 w-full" type="text" name="alamat_ktp"
                    :value="old('alamat_ktp')" required autofocus autocomplete="alamat_ktp" />
                <x-input-error :messages="$errors->get('alamat_ktp')" class="mt-2" />
            </div>

            <!-- Alamat Domisili -->
            <div>
                <x-input-label for="alamat_domisili" :value="__('Alamat Domisili')" />
                <x-text-input id="alamat_domisili" class="block mt-1 w-full" type="text" name="alamat_domisili"
                    :value="old('alamat_domisili')" required autofocus autocomplete="alamat_domisili" />
                <x-input-error :messages="$errors->get('alamat_domisili')" class="mt-2" />
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <x-input-label for="tgl_lahir" :value="__('Tanggal Lahir')" />
                <x-text-input id="tgl_lahir" class="block mt-1 w-full" type="date" name="tgl_lahir"
                    :value="old('tgl_lahir')" required autofocus autocomplete="tgl_lahir" />
                <x-input-error :messages="$errors->get('tgl_lahir')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="field-ktp" :value="__('KTP')" />
                <input type="file" name="ktp" id="field-ktp" accept=""
        class="w-full text-gray-400 font-semibold text-sm bg-white border file:cursor-pointer cursor-pointer file:border-0 file:py-3 file:px-4 file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500 rounded-lg" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Sudah punya akun') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Daftar sekarang') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
