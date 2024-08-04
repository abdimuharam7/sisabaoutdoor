<html>

<head>
    <title>Invoice {{ $data->kode_transaksi }}</title>

    <link rel="stylesheet" href="/css/bootstrap.css">

    <style>
        
        .table {
            border-collapse: collapse;
            width: 100%;
            font-size: 10pt;
        }

        .table td, .table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
        </style>
</head>

<body>
    <div class="container">
        <table width="100%">
            <tr>
                <td width="20%" class="text-center">
                    <img src="/gambar/logo.jpeg" width="120pt">
                </td>
                <td class="text-center" width="50%">
                    <h1 style="margin-bottom: 5px;font-size:42pt;font-weight: bold;">SABA OUTDOOR</h1>
                    <h2 style="margin-bottom: 5px;font-size:24pt;font-weight: bold;">EQUIPMENT RENT</h2>
                    <div style="width:100px;background:black;color:white;">
                        MENYEWAKAN
                    </div>
                    <p style="font-size: 9pt">Tenda,Carier, Sleeping Bag, Sepatu, Matras, Headlamp, Kompor, Nesting, Dll</p>
                </td>
            </tr>
        </table>
        <hr/>
        <h1 style="text-align:center;margin-bottom: 5px;font-size:16pt;font-weight: 600;">
            INVOICE
        </h1>
        <br/>
        <br/>
        <table style="width:100%">
            <tr>
                <td>Nama Penyewa</td>
            </tr>
        </table>
        <table class="table v-align-center table-bordered datatable w-100">
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Produk</th>
                    <th rowspan="2">Qty</th>
                    <th colspan="3">Kerusakan</th>
                    <th rowspan="2">Hilang</th>
                    <th rowspan="2">Denda</th>
                </tr>
                <tr>
                    <th>Ringan</th>
                    <th>Sedang</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->denda as $d)
                
                @php
                    $total = $d->total;
                @endphp

                    <tr>
                        <td>
                            {{ $loop->index+1}}
                        </td>
                        <td>
                            {{ $d->katalog->nama }}<br />
                            Rp. {{ number_format($d->katalog->harga, 0, ',', '.') }}
                        </td>
                        <td>
                            {{ $d->pesanan->qty  ?? 0}}
                        </td>
                        <td>
                            {{ $d->rusak_ringan  ?? 0}}
                        </td>
                        <td>
                            {{ $d->rusak_sedang  ?? 0}}
                        </td>
                        <td>
                            {{ $d->rusak_total  ?? 0}}
                        </td>
                        <td>
                            {{ $d->hilang  ?? 0}}
                        </td>
                        <td>
                            <span class="showDenda">Rp. {{ number_format($d->total,0,',','.') }}</span>
                        </td>
                    </tr>
                @endforeach
                {{-- @php
                    $no = 1;
                @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->produk->nama }}</td>
                        <td>{{ $data->qty }} Unit</td>
                        <td>{{ $data->lama }} Jam</td>
                        <td>Rp {{ number_format($data->harga_unit,0,',','.') }}</td>
                        <td>Rp {{ number_format($data->harga_operator,0,',','.') }}</td>
                        <td>Rp {{ number_format($data->total,0,',','.') }}</td>
                    </tr> --}}
            </tbody>
        </table>
        <br/>
        <table style="float: left;width: 100%;border-spacing: 0px;">
            <tr>
                <td width="60%"></td>
                <td>Total</td>
                <td>Rp. {{ number_format($data->total,0,',','.') }}</td>
            </tr>
        </table>
    </div>

</body>

</html>