<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Edit Data Sewa
        </h2>
    </x-slot>
    <div class="p-10">
        <form method="POST" action="{{ route('pemesanan.update', $pemesanan->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-3">
                <table class="min-w-full leading-normal mb-6">
                    <tbody>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">Kode Transaksi</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-600 whitespace-no-wrap">{{ $pemesanan->kode_transaksi }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">Tanggal Penyewaan</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-600 whitespace-no-wrap">{{ $pemesanan->tgl_penyewaan }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">Jam Pengambilan</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-600 whitespace-no-wrap">{{ $pemesanan->jam_pengambilan }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">Total</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-600 whitespace-no-wrap">{{ $pemesanan->harga }}</p>
                            </td>
                        </tr>
                        <!-- Tambahkan baris tabel tambahan sesuai dengan atribut yang ada dalam $pemesanan -->
                    </tbody>
                </table>
                <div>
                    <label for="status_penyewaan" class="block text-sm font-medium text-gray-700">Status Penyewaan</label>
                    <select name="status_penyewaan" id="status_penyewaan" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled selected> Pilih Status Penyewaan</option>
                        <option {{ $pemesanan->status_penyewaan == 'Menunggu' ? 'selected':'' }} value="Menunggu">Menunggu</option>
                        <option {{ $pemesanan->status_penyewaan == 'Diterima' ? 'selected':'' }} value="Diterima">Diterima</option>
                        <option {{ $pemesanan->status_penyewaan == 'Ditolak' ? 'selected':'' }} value="Ditolak">Ditolak</option>
                    </select>
                </div>
                <div>
                    <label for="status_pembayaran" class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                    <select name="status_pembayaran" id="status_pembayaran" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" disabled selected> Pilih Status Pembayaran</option>
                        <option {{ $pemesanan->status_pembayaran == 'Menunggu' ?'selected':'' }} value="Menunggu">Menunggu</option>
                        <option {{ $pemesanan->status_pembayaran == 'Dibayar' ?'selected':'' }} value="Dibayar">Dibayar</option>
                        <option {{ $pemesanan->status_pembayaran == 'gagal' ?'selected':'' }} value="gagal">Gagal</option>
                    </select>
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
