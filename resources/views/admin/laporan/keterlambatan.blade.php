<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Laporan Keterlambatan
        </h2>
    </x-slot>
    <div class="relative">
        <div class="min-w-full p-4 bg-white border border-gray-200 rounded-lg shadow">
            
            <form action="{{ route('admin.pemesanan.keterlambatan') }}" method="GET">
                <!-- Modal body -->
                <div class="grid grid-cols-2 gap-3">

                    <!-- Nama -->
                    <div>
                        <x-input-label for="tgl" :value="__('Tanggal Periode')" />
                        <x-text-input id="tgl" class="block mt-1 w-full" type="text" name="tgl" :value="old('tgl')"
                            required autofocus autocomplete="tgl" />
                        <x-input-error :messages="$errors->get('tgl')" class="mt-2" />
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Download
                    </button>
                    <button data-modal-hide="modalReport" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">BATAL</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script>
    $(document).ready(function() {
        $("#tgl").flatpickr({
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
            locale : "id",
            defaultDate: [new Date(Date.now() - 7 * 24 * 60 * 60 * 1000), new Date()],
            mode: "range"
        });
        
    })
</script>
