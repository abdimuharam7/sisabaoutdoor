<html>

<head>
    <title> Laporan Pengadaan</title>
    <link rel="stylesheet" href="/css/bootstrap.css">
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
        <div style="width:100%; padding:3px;background:black;"></div>
        <div style="width:100%; padding:1px;background:black; margin-top:4px;"></div>
        <br/>
        <br/>
        <h2 class="h3 text-center" style="font-weight: bold; margin-top:0px">LAPORAN PENGADAAN</h2>
        <h2 class="h4 text-center" style="font-weight: bold; margin-top:0px">
            Periode : {{ \Carbon\Carbon::parse($tgl[0])->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($tgl[1])->translatedFormat('d F Y') }}
        </h2>
        <br/>
        <table class="table table-bordered datatable w-100">
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th>Kode</th>
                    <th>Supplier</th>
                    <th>Tgl</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td class>{{ $loop->index+1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->supplier }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl)->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->status }}</td>
                    <td>
                        @php
                        $total = 0;
                        @endphp
                        @foreach ($item->item as $items)
                        @php
                            $total += $items->harga * $items->jumlah;
                        @endphp
                        @endforeach
                        <p> Rp. {{ number_format($total, 0, ',', '.') }}</p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>