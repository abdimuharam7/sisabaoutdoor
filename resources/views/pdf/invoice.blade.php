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
                <td>Pelanggan</td>
                <td>: {{ $data->user->nama }}</td>
                <td width="10%"></td>
                <td>Nomor Sewa</td>
                <td>: {{ $data->kode_transaksi }}</td>
            </tr>
        </table>
        <br/>
        <br/>
        <table class="table v-align-center table-bordered datatable w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data->item as $item)
                    <tr class="row-{{ $loop->index }}">
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $item->katalog->nama }}</td>
                        <td>{{ $item->jumlah }}</td>
                        <td>Rp. {{ number_format($item->katalog->harga,0,',','.') }}</td>
                        <td>Rp. {{ number_format($item->katalog->harga* $item->jumlah,0,',','.') }}</td>
                    </tr>
                @endforeach
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