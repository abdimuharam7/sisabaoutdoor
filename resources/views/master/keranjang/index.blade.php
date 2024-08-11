<x-layouts.app>
    <div class="">
        <form action="{{ route('pemesanan.store') }}" method="POST">
            @csrf
            @method('POST')
            <div class="space-y-3 p-10 max-w-2xl mx-auto">
                <ul  id="keranjang">
                    @foreach ($cart as $item)
                        <li class="item">
                            <div class="bg-white rounded-lg border py-3 px-10 grid grid-cols-3 ">
                                <div class="h-full w-full flex items-start flex-col justify-center">
                                    <img src="{{ asset('uploads/') }}/{{ $item->katalog->foto }}" class=" h-20 object-cover" alt="">
                                    <p>
                                        {{ $item->katalog->nama }}
                                    </p>
                                </div>
                                <div class="flex gap-3 items-center justify-center">
                                    <button type="button" class="btn-dcm">-</button>
                                    <input value="{{ $item->katalog->harga }}" type="hidden" class="harga" />
                                    <input value="{{ $item->jumlah }}" type="number" class="w-12 rounded-lg h-min qty" name="item[{{ $item->id }}][jumlah]" id="">
                                    <input value="{{ $item->katalog->id }}" type="hidden" name="item[{{ $item->id }}][id]" id="">
                                    <button type="button" class="btn-inc">+</button>
                                </div>
                                <div class="flex total">
                                    <div class="my-auto ms-auto">
                                        <p class="text-end">Rp. {{ number_format($item->katalog->harga,0,',','.') }}</p>
                                        <p class="text-end showTotal">Rp. {{ number_format($item->katalog->harga * $item->jumlah,0,',','.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <button data-modal-target="tambah-pemesanan" data-modal-toggle="tambah-pemesanan" type="button" class="py-3 text-center bg-green-500 text-white w-full rounded-lg hover:bg-opacity-90">
                    Sewa Sekarang
                </button>
                <x-modal.tambah-pemesanan></x-modal.tambah-pemesanan>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>

            
        function calculateTotal() {
            // var total = 0;
            $('ul#keranjang li').each(function() {
                // console.log($(this));
                var total =0;
                var qty = parseInt($(this).find('input.qty').val());
                var harga = parseInt($(this).find('.harga').val());
                if (!isNaN(qty) && !isNaN(harga)) {
                    total += qty * harga;
                }
                // console.log(total);
                $(this).find('p.showTotal').text(currency(total));
                // $(this).closest("div.total").hide();
                // alert('sa');
            });
        }

        function currency(angka){
            var number_string = angka.toString(),
            split   		= number_string.split(','),
            sisa     		= split[0].length % 3,
            rupiah     		= split[0].substr(0, sisa),
            ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp ' + rupiah;
        }
        
        $(document).ready(function() {
            $("#tgl_penyewaan").flatpickr({
                minDate : 'today',
                maxDate: new Date().fp_incr(7),
            });

            $("#jam_pengambilan").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });

            $('.btn-inc').click(function() {
                var $qty = $(this).siblings('.qty');
                var currentVal = parseInt($qty.val());
                if (!isNaN(currentVal)) {
                    $qty.val(currentVal + 1);
                } else {
                    $qty.val(0);
                }
                calculateTotal();
            });

            // Decrement
            $('.btn-dcm').click(function() {
                var $qty = $(this).siblings('.qty');
                var currentVal = parseInt($qty.val());
                if (!isNaN(currentVal) && currentVal > 0) {
                    $qty.val(currentVal - 1);
                } else {
                    $qty.val(0);
                }
                calculateTotal();
            });
        });
    </script>
    @endpush
</x-layouts.app>
