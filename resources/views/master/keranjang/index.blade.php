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
                                    <input value="{{ $item->id }}" type="hidden" class="cart_id" />
                                    <input value="{{ $item->katalog->harga }}" type="hidden" class="harga" />
                                    <input value="{{ $item->jumlah }}" type="number" class="w-12 rounded-lg h-min qty" name="item[{{ $item->id }}][jumlah]" min="1" max="{{ $item->katalog->stok }}" id="">
                                    <input value="{{ $item->katalog->id }}" type="hidden" name="item[{{ $item->id }}][id]" id="">
                                    <button type="button" class="btn-inc">+</button>
                                </div>
                                <div class="flex total">
                                    <div class="my-auto ms-auto">
                                        <p class="text-end showTotal">Rp. {{ number_format($item->katalog->harga * $item->jumlah,0,',','.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('katalog') }}" class="py-3 text-center bg-blue-500 text-white w-full rounded-lg hover:bg-opacity-90">
                        Tambahkan Barang Lain
                    </a>
                    <button id="btn-pesan" data-modal-target="tambah-pemesanan" {{ count($cart) ? '' : 'disabled="disabled"'}} data-modal-toggle="tambah-pemesanan" type="button" 
                    class="py-3 text-center bg-green-500 text-white w-full rounded-lg hover:bg-opacity-90 disabled:bg-green-300 disabled:cursor-not-allowed">
                        Sewa Sekarang
                    </button>
                </div>
            </div>
            <x-modal.tambah-pemesanan></x-modal.tambah-pemesanan>
        </form>
    </div>

    @push('scripts')
    @if($errors->any())
        <script>
            
            const modal = new Modal(document.getElementById('tambah-pemesanan'));
                modal.show();
        </script>
    @endif
    <script>
        
        // new Modal($('#tambah-pemesanan'), {}).show();

        function calculateTotal() {
            // var total = 0;
            $('ul#keranjang li').each(function() {
                // console.log($(this));
                var total =0;
                var qty = parseInt($(this).find('input.qty').val());
                var harga = parseInt($(this).find('.harga').val());
                var id = $(this).find('.cart_id').val();
                if (!isNaN(qty) && !isNaN(harga)) {
                    total += qty * harga;
                }
                var line = $(this);
                if(qty == 0){
                    $.ajax({
                        url: "/pelanggan/keranjang/"+ id +"/delete",
                        type: "DELETE",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        success: function(data) {
                            // alert(data.fail);
                            if(data.fail == false){
                                line.remove();


                                if(!$('ul#keranjang li').length){
                                    $('#btn-pesan').prop( "disabled", true );
                                }
                            }
                        },
                    });
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
                time_24hr: true,
                minTime: "07:00",
                maxTime: "22:00",
            });

            $('.btn-inc').click(function() {
                var $qty = $(this).siblings('.qty');
                var max = $qty.attr('max');
                var currentVal = parseInt($qty.val());
                if (!isNaN(currentVal)) {
                    if (currentVal < max) {
                        $qty.val(currentVal + 1);
                    } else {
                        $qty.val(currentVal);
                    }

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
