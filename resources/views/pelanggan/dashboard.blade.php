<x-layouts.app title="Dashboard">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h1 class="text-3xl font-bold mb-4">WILUJENG SUMPING !</h1>
            <p class="text-lg">Login Anda berhasil. Selamat menggunakan aplikasi kami !</p>
            {{-- {{ __('Dashboard') }} --}}
        </h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="text-justify">
                    <h3 class="text-2xl font-bold mb-4" id="peraturan">PERATURAN</h3>
                    <ol class="list-decimal list-inside">
                        <li class="mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2 text-gray-600"></i>
                            Penyewa wajib menjaga peralatan yang disewa.
                        </li>
                        <li class="mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2 text-gray-600"></i>
                            Penyewa diwajibkan untuk memberikan informasi yang benar dan lengkap saat mengisi formulir penyewaan.
                        </li>
                        <li class="mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2 text-gray-600"></i>
                            Pengambilan dan pengembalian hanya dilakukan di basecamp Saba Outdoor Equipment Rent.
                        </li>
                        <li class="mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2 text-gray-600"></i>
                            Minimal penyewaan adalah 1 x 24 jam terhitung sejak pengambilan peralatan.
                        </li>
                        <li class="mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2 text-gray-600"></i>
                            Jika pengembalian lebih cepat dari waktu sewa tidak ada pengembalian pembayaran.
                        </li>
                        <li class="mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2 text-gray-600"></i>
                            Sebagai jaminan penyewaan wajib menyerahkan kartu identitas meliputi KTP,SIM, atau Kartu Pelajar.
                        </li>
                        <li class="mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2 text-gray-600"></i>
                            Jika terjadi keterlambatan, kerusakan, dan kehilangan akan dikenakan denda sesuai dengan prosedur dan SK yang berlaku.
                        </li>
                        <li class="mb-2 flex items-center">
                            <i class="fas fa-check-circle mr-2 text-gray-600"></i>
                            SEGALA BENTUK TINDAK PIDANA AKAN KAMI SERAHKAN KEPADA PIHAK BERWENANG!!!
                        </li>
                    </ol>

                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold mb-4" id="katalog">KATALOG</h3>
                <div class="grid grid-cols-5 gap-4 p-10">
                    @foreach ($katalogs as $item)
                    <div class="rounded-lg border bg-white overflow-hidden shadow-lg">
                        <img src="{{ asset('uploads') }}/{{ $item->foto }}" class="h-52 w-full object-cover" alt="">
                        <div class="p-3 space-y-1">
                            <p class="line-clamp-1 font-bold capitalize cursor-pointer" data-modal-target="show-deskripsi-{{ $item->id }}" data-modal-toggle="show-deskripsi-{{ $item->id }}">{{ $item->nama }}</p>
                            <x-modal.show-deskripsi :katalog="$item">
            
                            </x-modal.show-deskripsi>
                            <p>Rp. {{ number_format($item->harga,0,',','.') }}</p>
                            <div class="flex justify-between">
                                <p class="text-xs">{{ $item->stok }} Stok Tersedia</p>
                                <p class="text-xs">{{ $item->satuan }}</p>
                            </div>
                            <form action="{{ route('keranjang.store', $item->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="katalog_id" value="{{ $item->id }}">
                                <button type="submit" {{ $item->stok ? '' : 'disabled="disabled"' }}  class="bg-green-500 rounded-lg text-white w-full py-1 disabled:bg-green-300 disabled:cursor-not-allowed">
                                    Tambah Keranjang
                                </button>
                            </form>
                        </div>
            
                    </div>
                    @endforeach
            
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
