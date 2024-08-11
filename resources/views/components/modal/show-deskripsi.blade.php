@props(['katalog'])
<div id="show-deskripsi-{{ $katalog->id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Deskripsi Alat </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="show-deskripsi-{{ $katalog->id }}">
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
                <div class="flex gap-1">
                    <p class="w-[65px] flex-none">Nama</p>
                    <p>:</p>
                    <p>{{ $katalog->nama }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-[65px] flex-none">Stok</p>
                    <p>:</p>
                    <p>{{ $katalog->stok }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-[65px] flex-none">Satuan</p>
                    <p>:</p>
                    <p>{{ $katalog->satuan }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-[65px] flex-none">Harga</p>
                    <p>:</p>
                    <p>Rp. {{ number_format($katalog->harga,0,',','.') }}</p>
                </div>
                <div class="flex gap-1">
                    <p class="w-[65px] flex-none">Deskripsi</p>
                    <p>:</p>
                    <p>{{ $katalog->deskripsi }}</p>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <form action="{{ route('keranjang.store', $katalog->id) }}" method="POST">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="katalog_id" value="{{ $katalog->id }}">
                    <button type="submit" class="bg-green-500 rounded-lg text-white w-full py-1">Tambah Keranjang</button>
                </form>
            </div>
        </div>
    </div>
</div>
