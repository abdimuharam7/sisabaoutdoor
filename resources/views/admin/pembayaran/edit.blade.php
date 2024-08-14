<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Edit Data Sewa
        </h2>
    </x-slot>
        <div class="relative">
            <div class="min-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <form action="{{ route('admin.pemesanan.update', $data->id)}}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div class="mb-2">
                            <x-input-label for="field-pelanggan_id" value="Pelanggan" />
                            <x-select-field id="pelanggan_id" name="pelanggan_id" placeholder="Pilih"
                                :options="$konsumen" value="{{ $data->user_id }}" />
                            <x-input-error :messages="$errors->get('pelanggan_id')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                            <x-input-label for="field-tgl" value="Tanggal Sewa" />
                            <x-text-input id="field-tgl" class="block mt-1 w-full" type="text" name="tgl"
                                :value="old('tgl', $data->tgl_penyewaan)" />
                            <x-input-error :messages="$errors->get('tgl')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                            <x-input-label for="field-waktu" value="Jam Pengembalian" />
                            <x-text-input id="field-waktu" class="block mt-1 w-full" type="text" name="waktu"
                                :value="old('waktu', $data->jam_pengambilan)" />
                            <x-input-error :messages="$errors->get('waktu')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                            <x-input-label for="field-lama" value="Lama" />
                            <x-text-input id="field-lama" class="block mt-1 w-full" min="1" type="text" name="lama"
                                :value="old('lama', $data->durasi)" />
                            <x-input-error :messages="$errors->get('lama')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                            <x-input-label for="field-jaminan" value="Jaminan" />
                            <x-select-field id="jaminan" name="jaminan" placeholder="Pilih" value="{{ $data->jaminan }}"
                                :options="[
                                ['label' => 'KTP', 'value' => 'KTP'],
                                ['label' => 'SIM', 'value' => 'SIM'],
                                ['label' => 'Kartu Pelajar', 'value' => 'KPelajar'],
                            ]" />
                            <x-input-error :messages="$errors->get('jaminan')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                            <x-input-label for="field-status" value="Status" />
                            <x-select-field id="status" name="status" placeholder="Pilih"
                                value="{{ $data->status_penyewaan }}" :options="[
                                ['label' => 'Menunggu', 'value' => 'Menunggu'],
                                ['label' => 'Diterima', 'value' => 'Diterima'],
                                ['label' => 'Ditolak', 'value' => 'Ditolak'],
                            ]" />
                            <x-input-error :messages="$errors->get('status_penyewaan')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                            <x-input-label for="field-status" value="Status Pembayaran" />
                            <x-select-field id="status_pembayaran" name="status_pembayaran" placeholder="Pilih"
                                value="{{ $data->status_penyewaan }}" :options="[
                                ['label' => 'Dibayar', 'value' => 'Dibayar'],
                                ['label' => 'Belum Bayar', 'value' => 'Menunggu'],
                            ]" />
                            <x-input-error :messages="$errors->get('status_pembayaran')" class="mt-2" />
                        </div>
                    </div>

                    <table id="table-detail" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                    Produk
                                </th>
                                <th width="70px" scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                    Jumlah
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                    Harga / Hari
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                    Subtotal
                                </th>
                                <th width="100px" scope="col"
                                    class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                            @php
                            $i = 0;
                            @endphp
                            @foreach ($data->item as $item)
                            <tr class="row-{{ $i }}">
                                <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-800 dark:text-neutral-200">
                                    <input type="hidden" name="lines[{{ $i }}][id]" class="line-id"
                                        value="{{ $item->id }}" />
                                    <x-select-field id="produk_id" class="produk-select"
                                        name="lines[{{ $i }}][produk_id]" value="{{ $item->katalog_id }}"
                                        :options="$produk" placeholder="Pilih" />
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                    <x-text-input id="field-qty" class="block mt-1 w-full line-qty" type="number"
                                        min="1" value="{{ $item->jumlah }}" name="lines[{{ $i }}][qty]" />
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                    <span class="showHarga">Rp. {{ $item->katalog->harga }}</span>
                                    <input type="hidden" name="lines[{{ $i }}][harga]" class="line-harga"
                                        value="{{ $item->katalog->harga }}" />
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                    <span class="showSubtotal">Rp. {{ $item->katalog->harga * $item->jumlah }}</span>
                                    <input type="hidden" name="lines[{{ $i }}][subtotal]" class="line-subtotal"
                                        value="{{ $item->katalog->harga * $item->jumlah }}" />
                                </td>
                                <td class="px-3 py-2 whitespace-nowrap text-end font-medium">
                                </td>
                            </tr>
                            @php
                            $i++;
                            @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="px-2 py-4">
                                    <button type="button" onclick="addRow()"
                                        class="bg-blue-600 border focus:outline-none font-medium py-2 rounded text-center text-white w-full">
                                        Tambah
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"
                                    class="dark:text-neutral-200 font-bold px-3 py-2 text-end text-gray-800 text-lg whitespace-nowrap">
                                    Total
                                </td>
                                <td colspan="2"
                                    class="dark:text-neutral-200 font-bold px-3 py-2 text-end text-gray-800 text-lg whitespace-nowrap">

                                    @php
                                    $total = 0;
                                    @endphp
                                    @foreach ($data->item as $it)
                                    @php
                                    $total += $it->katalog->harga * $it->jumlah;
                                    @endphp
                                    @endforeach
                                    <span class="showTotal">Rp. {{ number_format($total, 0, ',', '.') }}</span>
                                    <input type="hidden" name="total" id="field-total" value="{{ $total }}" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"
                                    class="dark:text-neutral-200 font-bold px-3 py-2 text-end text-gray-800 text-lg whitespace-nowrap">
                                    Total Tagihan
                                </td>
                                <td colspan="2"
                                    class="dark:text-neutral-200 font-bold px-3 py-2 text-end text-gray-800 text-lg whitespace-nowrap">
                                    <span class="showGrandTotal">Rp.
                                        {{ number_format($total * $data->durasi, 0, ',', '.') }}</span>
                                    <input type="hidden" name="grand_total" id="field-grand_total" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <button type="submit"
                        class="bg-blue-600 border focus:outline-none font-medium py-2 rounded text-center text-white px-5">
                        Simpan
                    </button>
                </form>
            </div>
            
        </div>
        @push('scripts')
        <script>
            let idx = parseFloat("{{ $data->item->count() }}");
            var table = $("#table-detail");
            $(document).on('change', '.produk-select', function() {
                var val = $(this).val();
                var tr = $(this).closest('tr');
                var qty = tr.find('.line-qty').val();
                $.ajax({ 
                    type: 'GET', 
                    url: `/admin/katalog/${val}/json`,
                    data: { get_param: 'value' }, 
                    dataType: 'json',
                    success: function (data) {
                        tr.find('.showHarga').html(currency(data.harga));
                        tr.find('.line-harga').val(data.harga);
                        tr.find('.line-subtotal').val(data.harga * qty);
                        tr.find('.showSubtotal').html(currency(data.harga * qty));
                        calculateTotal();
                    }
                });
            });

            
            $(document).on('click', '.btn_delete', function() {
                $(this).closest('tr').remove();
                calculateTotal();

            });
            
            $(document).on('change', '.line-qty', function() {
                var qty = $(this).val();
                var tr = $(this).closest('tr');
                var harga = tr.find('.line-harga').val();
                if(qty < 1){
                    $(this).val(1);
                }
                tr.find('.line-subtotal').val(harga * qty);
                tr.find('.showSubtotal').html(currency(harga * qty));
                calculateTotal();

            });

            $("#field-lama").on("change", function(e){
                calculateTotal();
            });
            
            $(document).ready(function() {
                $("#field-tgl").flatpickr({
                    maxDate: new Date().fp_incr(7),
                });

                $("#field-waktu").flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true
                });
            });
            

            function calculateTotal() {
                let total = 0;
                $('#table-detail tbody .line-subtotal').each(function() {
                    let harga = parseFloat($(this).val());
                    if (!isNaN(harga)) {
                        total += harga;
                    }
                });

                var lama = $("#field-lama").val();
                $('.showTotal').html(currency(total));
                $('#field-total').val(total);

                $('.showGrandTotal').html(currency(total*lama));
                $('#field-grand_total').val(total*lama);
            }

            function addRow(){

                var row = `
                    <tr class="row-${idx}">
                    <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-800 dark:text-neutral-200">
                        <x-select-field id="produk_id-${idx}" class="produk-select" name="lines[${idx}][produk_id]" :options="$produk" placeholder="Pilih"/>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                        <x-text-input id="field-qty" class="block mt-1 w-full line-qty" type="number" min="1" value="1" name="lines[${idx}][qty]"/>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                        <span class="showHarga">Rp. 0</span>
                        <input type="hidden" name="lines[${idx}][harga]" class="line-harga"/>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                        <span class="showSubtotal">Rp. 0</span>
                        <input type="hidden" name="lines[${idx}][subtotal]" class="line-subtotal"/>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-end font-medium">
                        <button type="button" class="btn_delete bg-red-600 border focus:outline-none font-medium py-2 rounded text-center text-white px-5">
                        Hapus
                        </button>
                    </td>
                    </tr>`;

                table.find("tbody").append(row);
                calculateTotal()
            }
        </script>
        @endpush
</x-app-layout>
