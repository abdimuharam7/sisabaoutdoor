<div id="tambah-pemesanan" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Tambah Pesanan </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="tambah-pemesanan">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div class="flex flex-col gap-1">
                    <label for="tgl_penyewaan">Tanggal Penyewaan</label>
                    <input class="rounded-lg" type="date" name="tgl_penyewaan" id="tgl_penyewaan" required>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="durasi">Durasi</label>
                    <input class="rounded-lg" type="number" name="durasi" id="durasi" required>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="jam_pengambilan">Jam Pengambilan</label>
                    <input class="rounded-lg" type="time" name="jam_pengambilan"  id="jam_pengambilan" required>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="jaminan">Jaminan</label>
                    <select class="rounded-lg" name="jaminan" id="jaminan" required>
                        <option value="" disabled selected > Pilih Jaminan</option>
                        <option value="KTP">KTP</option>
                        <option value="SIM">SIM</option>
                        <option value="KPelajar">Kartu Pelajar</option>
                    </select>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    SIMPAN</button>
                <button data-modal-hide="tambah-pemesanan" type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">BATAL</button>
            </div>
        </div>
    </div>
</div>
