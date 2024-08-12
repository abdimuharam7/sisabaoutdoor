<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Tambah Pembelian
        </h2>
    </x-slot>
        <div class="relative">
            <div class="min-w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <form action="{{ route('admin.pengadaan.store')}}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
    
                        <div class="mb-2">
                            <x-input-label for="field-tgl" value="Tanggal Pengadaan" />
                            <x-text-input id="field-tgl" class="block mt-1 w-full" type="text" name="tgl" :value="old('tgl')"/>
                            <x-input-error :messages="$errors->get('tgl')" class="mt-2" />
                        </div>
                        <div class="mb-2">
                            <x-input-label for="field-supplier" value="Supplier" />
                            <x-text-input id="field-supplier" class="block mt-1 w-full" type="text" name="supplier" :value="old('supplier')"/>
                            <x-input-error :messages="$errors->get('supplier')" class="mt-2" />
                        </div>
                    </div>
                    
                    <table id="table-detail" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                          <tr>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                Produk
                            </th>
                            <th width="70px" scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                Stok
                            </th>
                            <th width="70px" scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                Jumlah
                            </th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                Harga Beli
                            </th>
                            <th width="250px" scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                Subtotal
                            </th>
                            <th width="100px" scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                Aksi
                            </th>
                          </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                          <tr class="row-0">
                            <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-800 dark:text-neutral-200">
                                <x-select-field id="produk_id" class="produk-select" name="lines[0][produk_id]" :options="$produk" placeholder="Pilih"/>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <span class="showStok">0</span>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <x-text-input id="field-qty" class="block mt-1 w-full line-qty" type="number" min="1" value="1" name="lines[0][qty]"/>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <x-text-input id="field-harga" class="block mt-1 w-full line-harga" type="number" name="lines[0][harga]"/>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <span class="showSubtotal">Rp. 0</span>
                                <input type="hidden" name="lines[0][subtotal]" class="line-subtotal"/>
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap text-end font-medium">
                            </td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="6" class="px-2 py-4">
                                <button type="button" onclick="addRow()" class="bg-blue-600 border focus:outline-none font-medium py-2 rounded text-center text-white w-full">
                                    Tambah
                                </button>
                            </td>
                          </tr>
                          <tr>
                              <td colspan="4" class="dark:text-neutral-200 font-bold px-3 py-2 text-end text-gray-800 text-lg whitespace-nowrap">
                                  Total
                              </td>
                              <td colspan="2" class="dark:text-neutral-200 font-bold px-3 py-2 text-end text-gray-800 text-lg whitespace-nowrap">
                                  <span class="showTotal">Rp. 0</span>
                                  <input type="hidden" name="total" id="field-total"/>
                              </td>
                          </tr>
                        </tfoot>
                      </table>

                      <button type="submit" class="bg-blue-600 border focus:outline-none font-medium py-2 rounded text-center text-white px-5">
                        Simpan
                      </button>
                </form>
            </div>
            
        </div>
        @push('scripts')
        <script>
            let idx = 1;
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
                        tr.find('.showStok').html(data.stok);
                    }
                });
            });

            
            $(document).on('click', '.btn_delete', function() {
                $(this).closest('tr').remove();
                calculateTotal();

            });
            
            $(document).on('change', '.line-harga', function() {
                var tr = $(this).closest('tr');
                var harga = $(this).val();
                var qty = tr.find('.line-qty').val();
                if(qty < 1){
                    $(this).val(1);
                }
                tr.find('.line-subtotal').val(harga * qty);
                tr.find('.showSubtotal').html(currency(harga * qty));
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
            
            $(document).ready(function() {
                $("#field-tgl").flatpickr({
                    defaultDate : 'today',
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
            }

            function addRow(){

                var row = `
                    <tr class="row-${idx}">
                    <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-800 dark:text-neutral-200">
                        <x-select-field id="produk_id-${idx}" class="produk-select" name="lines[${idx}][produk_id]" :options="$produk" placeholder="Pilih"/>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                        <span class="showStok">0</span>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                        <x-text-input id="field-qty" class="block mt-1 w-full line-qty" type="number" min="1" value="1" name="lines[${idx}][qty]"/>
                    </td>
                    <td class="px-3 py-2 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                        <x-text-input id="field-harga${idx}" class="block mt-1 w-full line-harga" type="number" name="lines[${idx}][harga]"/>
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
