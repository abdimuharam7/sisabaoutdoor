<x-app-layout>
    <x-slot name="header">
        <!-- Header content goes here -->
        <h2 class="font-semibold text-xl text-black-800 leading-tight">
            Tambah Pengembalian
        </h2>
    </x-slot>
    <div class="relative">
        <div
            class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <form action="{{ route('admin.pengembalian.store')}}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div class="mb-2">
                        <x-input-label for="field-pemesanan_id" value="Pemesanan" />
                        {{-- <x-select-field id="pemesanan_id" name="pemesanan_id" placeholder="Pilih"
                            :options="$pemesanan" /> --}}
                        <select id="pemesanan_id" class="w-full" name="pemesanan_id" placeholder="Pilih">
                            <option value=""></option>
                            @foreach ($pemesanan as $p)
                            <option value="{{ $p->value}}">{{ $p->label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('pemesanan_id')" class="mt-2" />
                    </div>
                    <div class="mb-2">
                        <x-input-label for="field-tgl" value="Tanggal Kembali" />
                        <x-text-input id="field-tgl" class="block mt-1 w-full" type="text" name="tgl"
                            :value="old('tgl')" />
                        <x-input-error :messages="$errors->get('tgl')" class="mt-2" />
                    </div>
                    <div class="mb-2">
                        <x-input-label value="Keterlambatan" />
                        <div id="showLambat">0 Hari</div>
                        <input type="hidden" id="field-lambat" name="lambat" value="0"/>
                        <x-input-error :messages="$errors->get('lama')" class="mt-2" />
                    </div>
                    <div class="mb-2">
                        <x-input-label for="field-status" value="Status Pengembalian" />
                        <x-select-field id="status" name="status" placeholder="Pilih" :options="[
                                ['label' => 'Menunggu', 'value' => 'Menunggu'],
                                ['label' => 'Diterima', 'value' => 'Diterima'],
                                ['label' => 'Ditolak', 'value' => 'Ditolak'],
                            ]" />
                        <x-input-error :messages="$errors->get('jaminan')" class="mt-2" />
                    </div>
                </div>
                <div class="relative overflow-x-auto">
                <table id="table-detail" class="w-full text-sm border-gray-300">
                    <thead class="border border-gray-300 bg-gray-50">
                        <tr class=" ">
                            <th scope="col" rowspan="2" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Produk
                            </th>
                            <th width="50px" rowspan="2" scope="col" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Jumlah
                            </th>
                            <th colspan="3" scope="col" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Rusak
                            </th>
                            <th scope="col" width="70px" rowspan="2" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Hilang
                            </th>
                            <th scope="col" rowspan="2" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Keterangan
                            </th>
                            <th colspan="4" scope="col" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Denda
                            </th>
                        </tr>
                        <tr class="divide-x divide-y divide-gray-300">
                            <th scope="col" width="50px" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Ringan 10%
                            </th>
                            <th scope="col" width="50px" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Sedang 25%
                            </th>
                            <th scope="col" width="50px" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Total 50%
                            </th>
                            <th scope="col" rowspan="2" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Rusak
                            </th>
                            <th scope="col" rowspan="2" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Telat
                            </th>
                            <th scope="col" rowspan="2" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Hilang
                            </th>
                            <th scope="col" rowspan="2" class="px-3 py-3 border border-gray-300 text-center text-sm font-medium text-gray-500 uppercase">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="border border-gray-300">

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7"
                                class="dark:text-neutral-200 font-bold px-3 py-2 text-end text-gray-800 text-lg whitespace-nowrap">
                                Total Denda
                            </td>
                            <td colspan="4"
                                class="dark:text-neutral-200 font-bold px-3 py-2 text-end text-gray-800 text-lg whitespace-nowrap">
                                <span class="showTotal">Rp. 0</span>
                                <input type="hidden" name="total" id="field-total" />
                            </td>
                        </tr>
                    </tfoot>
                </table>
                </div>

                <button type="submit"
                    class="bg-blue-600 border focus:outline-none font-medium py-2 rounded text-center text-white px-5">
                    Simpan
                </button>
            </form>
        </div>
    </div>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let idx = 1;
        var table = $("#table-detail");
        $(document).on('change', '#pemesanan_id', function() {
            var val = $(this).val();
            $.ajax({ 
                type: 'GET', 
                url: `/admin/pemesanan/${val}/json`,
                dataType: 'json',
                success: function (data) {
                    var dt = new Date(data.tgl_penyewaan).fp_incr(data.durasi);
                    // console.log(data.jam_pengambilan);
                    var tm = data.jam_pengambilan.split(":")
                    dt.setHours(tm[0]);
                    dt.setMinutes(tm[1]);

                    var dt2 = $("#field-tgl").val();
                    var lambat = getDateDifference(dt, dt2);
                    // console.log(lambat);
                    $("#showLambat").html(`${ lambat } Hari`);
                    $("#field-lambat").val(lambat);

                    var row = '';
                    $.each(data.item, function(index, item) {
                        var denda = 0;
                        if(lambat){
                            var denda = item.katalog.harga * lambat;
                        }

                        row += `
                            <tr class="row-${idx}">
                            <td class="px-3 py-2 border border-gray-300 whitespace-nowrap font-medium text-gray-800 dark:text-neutral-200">
                                ${ item.katalog.nama }<br/>
                                ${ currency(item.katalog.harga) }
                            </td>
                            <td class="px-3 py-2 border border-gray-300 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                            ${ item.jumlah}
                            </td>
                            <td class="px-2 py-2 border border-gray-300 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <x-text-input id="field-rusak_ringan" class="block mt-1 w-full line-rusak_ringan" type="number" min="0" value="0" name="lines[${idx}][rusak_ringan]"/>
                            </td>
                            <td class="px-2 py-2 border border-gray-300 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <x-text-input id="field-rusak_sedang" class="block mt-1 w-full line-rusak_sedang" type="number" min="0" value="0" name="lines[${idx}][rusak_sedang]"/>
                            </td>
                            <td class="px-2 py-2 border border-gray-300 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <x-text-input id="field-rusak_total" class="block mt-1 w-full line-rusak_total" type="number" min="0" value="0" name="lines[${idx}][rusak_total]"/>
                            </td>
                            <td class="px-2 py-2 border border-gray-300 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <x-text-input id="field-hilang" class="block mt-1 w-full line-hilang" type="number" min="0" value="0" name="lines[${idx}][hilang]"/>
                            </td>
                            <td class="px-3 py-2 border border-gray-300 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <x-text-input id="field-keterangan" class="block mt-1 w-full" type="text" name="lines[${idx}][keterangan]"/>
                            </td>
                            <td class="px-3 py-2 border border-gray-300 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <span class="showRusak">${ currency(0)}</span>
                            </td>
                            <td class="px-3 py-2 border border-gray-300 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <span class="showHilang">${ currency(0)}</span>
                            </td>
                            <td class="px-3 py-2 border border-gray-300 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <span class="showLambat">${ currency(denda)}</span>
                            </td>
                            <td class="px-3 py-2 border border-gray-300 whitespace-nowrap text-gray-800 dark:text-neutral-200">
                                <span class="showDenda">${ currency(denda)}</span>
                                <input type="hidden" name="lines[${idx}][pesan_line_id]" value="${ item.id }"/>
                                <input type="hidden" name="lines[${idx}][produk_id]" class="line-produk_id" value="${ item.katalog_id }"/>
                                <input type="hidden" name="lines[${idx}][denda]" class="line-denda" value="${ denda }"/>
                                <input type="hidden" name="lines[${idx}][harga]" class="line-harga"  value="${item.katalog.harga_beli ?? 0}"/>
                                <input type="hidden" name="lines[${idx}][normal]" class="line-normal"  value="${item.jumlah}"/>
                                <input type="hidden" name="lines[${idx}][lambat]" class="line-lambat" value="${ denda }"/>
                            </td>
                            </tr>`;

                            idx++;
                        
                    });
                    table.find('tbody').html(row);
                    calculateTotal();
                }
            });
        });

        $(document).ready(function() {
            $('#pemesanan_id').select2({
                placeholder: 'Pilih',
                // allowClear : true
            });
        });

        $(document).on('click', '.btn_delete', function() {
            $(this).closest('tr').remove();
            calculateTotal();

        });
        
        $(document).on('change', '.line-rusak_ringan, .line-rusak_sedang, .line-rusak_total, .line-hilang', function() {
            var tr = $(this).closest('tr');
            var harga = tr.find('.line-harga').val();
            var sisa = tr.find('.line-normal').val();
            var rusak_ringan = parseFloat(tr.find('.line-rusak_ringan').val());
            var rusak_sedang = parseFloat(tr.find('.line-rusak_sedang').val());
            var rusak_total = parseFloat(tr.find('.line-rusak_total').val());
            var hilang = tr.find('.line-hilang').val();
            var lambat = parseFloat(tr.find('.line-lambat').val());

            var denda_ringan = 0;
            var denda_sedang = 0;
            var denda_total = 0;
            var denda_hilang = 0;
            if(rusak_ringan){
                denda_ringan = (harga*.1)*rusak_ringan;

                sisa -= rusak_ringan;
            }
            if(rusak_sedang){
                denda_sedang = (harga*.25)*rusak_sedang;
                sisa -= rusak_sedang;
                tr.find('.line-normal').val(sisa);
            }
            if(rusak_total){
                denda_total = (harga*.5)*rusak_total;
                sisa -= rusak_total;
                tr.find('.line-normal').val(sisa);
            }

            if(hilang){
                denda_hilang = (harga*.7)*hilang;
            }
            

            var total_denda = denda_ringan + denda_sedang + denda_total + denda_hilang + lambat;
            // console.log(denda_ringan);
            tr.find('.line-denda').val(total_denda);
            tr.find('.showDenda').html(currency(total_denda));
            tr.find('.showHilang').html(currency(denda_hilang));
            tr.find('.showRusak').html(currency(denda_ringan + denda_sedang + denda_total ));
            calculateTotal();

        });

        $("#field-lama").on("change", function(e){
            calculateTotal();
        });
        
        $(document).ready(function() {
            $("#field-tgl").flatpickr({
                defaultDate : 'today',
                enableTime: true,
                dateFormat: "d M Y H:i",
                time_24hr: true
            });
        });
        function isMoreThanOneDay(date1, date2) {
            var d1 = new Date(date1);
            var d2 = new Date(date2);

            // Hitung selisih dalam milidetik
            var diff = Math.abs(d1.getTime() - d2.getTime());

            // Konversi milidetik ke hari
            var diffDays = diff / (1000 * 60 * 60 * 24);

            return diffDays > 1;
        }

        function getDateDifference(date1, date2) {
            
            var d1 = new Date(date1);
            var d2 = new Date(date2);
            var diffDays = 0;
            if (d2 > d1) {
                var timeDiff = Math.abs(d2 - d1);
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
            }

            return diffDays;
        }

        function calculateTotal() {
            let total = 0;
            $('#table-detail tbody .line-denda').each(function() {
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

            var row = ``;

            table.find("tbody").append(row);
            calculateTotal()
        }
    </script>
    @endpush
</x-app-layout>
