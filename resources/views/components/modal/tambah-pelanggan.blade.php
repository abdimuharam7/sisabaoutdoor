<div id="tambah-pelanggan" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-3xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Pesanan </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="tambah-pelanggan">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            
            <form method="POST" action="{{ route('admin.pelanggan.store') }}">
                @csrf
                @method('POST')
                <div class="grid grid-cols-2 gap-3 p-4">

                    <!-- Nama -->
                    <div>
                        <x-input-label for="nama" :value="__('Nama')" />
                        <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')"
                            required autofocus autocomplete="nama" />
                        <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                    </div>

                    <!-- Jenis kelamin -->
                    <div>
                        <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                        <select id="jenis_kelamin" name="jenis_kelamin"
                            class="block mt-1 w-full rounded-lg border-gray-300" required autofocus
                            autocomplete="jenis_kelamin">
                            <option value="Laki-Laki" {{ old('jenis_kelamin') == 'Laki-Laki' ? 'selected' : '' }}>
                                Laki-Laki
                            </option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
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
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="field-ktp" :value="__('KTP')" />
                        <input type="file" name="ktp" id="field-ktp" accept=""
                            class="w-full text-gray-400 font-semibold text-sm bg-white border file:cursor-pointer cursor-pointer file:border-0 file:py-3 file:px-4 file:mr-4 file:bg-gray-100 file:hover:bg-gray-200 file:text-gray-500 rounded-lg" />
                        <x-input-error :messages="$errors->get('ktp')" class="mt-2" />
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
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    SIMPAN</button>
                <button data-modal-hide="tambah-pelanggan" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">BATAL</button>
            </div>
        </form>
        </div>
    </div>
</div>
