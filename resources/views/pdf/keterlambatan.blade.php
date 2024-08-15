<html>

<head>
    <title> Laporan Keterlambatan</title>
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
        <h2 class="h3 text-center" style="font-weight: bold; margin-top:0px">LAPORAN KETERLAMBATAN</h2>
        <h2 class="h4 text-center" style="font-weight: bold; margin-top:0px">
            Periode : {{ \Carbon\Carbon::parse($tgl[0])->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($tgl[1])->translatedFormat('d F Y') }}
        </h2>
        <br/>
        <table class="table table-bordered datatable w-100">
            <thead>
                <tr>
                    <th width="50px">No</th>
                    <th>Kode Pesanan</th>
                    <th>Pelanggan</th>
                    <th>No Hp/Wa</th>
                    <th>Alamat</th>
                    <th>Tgl Kembali</th>
                    <th>Telat</th>
                    <th>Alat</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_all = 0;
                    $no = 1;
                @endphp
                @foreach ($data as $d)
                @php
                    $created =  \Carbon\Carbon::parse($d->tgl_penyewaan)->setTimeFromTimeString($d->jam_pengambilan)->addDay($d->durasi);
                    $now = \Carbon\Carbon::now();
                    $diff = $created->diff($now)->days;
                @endphp
                @if($diff)
                <tr>
                    <td class>{{ $no++ }}</td>
                    <td>{{ $d->kode_transaksi }}</td>
                    <td>{{ $d->user->nama }}</td>
                    <td>{{ $d->user->nomor_wa }}</td>
                    <td>{{ ucwords($d->user->alamat_domisili) }}</td>
                    <td>
                        {{ $created->translatedFormat('d F Y H:i') }}
                    </td>
                    <td>
                        {{ $diff }} Hari
                    </td>
                    <td>
                        @foreach ($d->item as $i)
                            {{$i->jumlah}} {{ $i->katalog->nama }},
                        @endforeach
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
    </div>

</body>

</html>