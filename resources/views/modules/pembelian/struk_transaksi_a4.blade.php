<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Struk Pembelian/Kulak</title>
    <style type="text/css" media="print">
        @page {
            size: landscape
        }
        .font-weight-bold{
            font-weight : bold;
        }
        .text-center{
            text-align:Center;
        }
        
        table#detail_item  td, table#detail_item  th{
            border : 1px solid black;
        }


        table#detail_item{
            border-collapse : collapse;
        }
        /* @page {
            margin: 0;

        }

        .body {
            margin: 0in 0.2in 0in 0.3in;

            font-family: Arial, Helvetica, sans-serif;
        }

        .footer {
            position: absolute;
            bottom: 0;
        }

        h6{
            font-size:10px;
            font-weight:100;
        }

        p,td {
            font-size: 10px;
        }

        td{
            height:5px;
        } */
    </style>
</head>

<body>
    <h6 style="margin-top:0px;">APOTEK KARTINI MAS MANDIRI</h6>
    <h6 style="margin-top:-25px;">Jl. Raya Gedang Mas</h6>
    <h6 style="margin-top:-25px;">Randuagung, Telp. 0334-322181</h6>
    <h6 style="margin-top:-25px;">Lumajang - Jatim</h6>

    <!-- Data Master Transaksi -->
    <table style="margin-top:-10px;">
        <tr>
            <td>No. Pembelian</td>
            <td>:</td>
            <td>{{ $master->id }}</td>
            <td style="padding-left:35px;"></td>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ $master->created_at }}</td>
        </tr>
        <tr>
            <td>Supplier</td>
            <td>:</td>
            <td>@if($master->nama_supplier != "") {{ $master->nama_supplier }} @else {{"-"}} @endif</td>
            <td style="padding-left:35px;"></td>
            <td>Status Pembayaran</td>
            <td>:</td>
            <td>@if($master->status_pembayaran == 1) {{ "Lunas" }}  @else {{"Belum Lunas"}} @endif</td>
        </tr>
        <tr>
            <td>Cara Pembayaran</td>
            <td>:</td>
            <td>{{ $master->cara_pembayaran}}</td>
            <td style="padding-left:35px;"></td>
            
            @if($master->cara_pembayaran == "Kredit")
            <td>Jatuh Tempo</td>
            <td>:</td>
            <td>{{ $master->jatuh_tempo }}</td>
            @endif

        </tr>
    </table>

    <hr style="border-top:1px dotted black">
    
    <!-- Data Detail Transaksi -->
    <table style="width:100%" id="detail_item" class="">
        <thead>
            <tr>
                <th style="width:3%;max-width:2%">No.</th>
                <th class="text-center">Kode</th>
                <th class="text-center">Item</th>
                <th class="text-center">Satuan</th>
                <th class="text-center">Harga</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Subtotal</th>
            </tr>
        </thead>
        @php $no=1 @endphp
        @foreach($detail_pembelian as $detail)
        <tbody>
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $detail->produk_id }}</td>
                <td>{{ $detail->nama_produk }}</td>
                <td>{{ $detail->satuan }}</td>
                <td style="text-align:right">{{ number_format($detail->harga,0,',','.') }}</td>
                <td style="width:10%">{{ $detail->qty }}</td>
                <td style="text-align:right;">{{ number_format($detail->subtotal,0,',','.') }}</td>
            </tr>
        </tbody>

        <!-- <tr>
            <td colspan="3">{{ $detail->nama_produk }}</td>
        </tr>
        <tr>
            
        </tr> -->
        @endforeach
    </table>
    
    <!-- Data Master Transaksi -->
    <table style="margin-top:10px;">
        <!-- Pasien -->
        <tr>
            <td class="font-weight-bold">Total</td>
            <td>:</td>
            <td>{{ number_format($master->total,0,',','.') }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Diskon</td>
            <td>:</td>
            <td>{{ number_format($master->diskon,0,',','.') }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Grand Total</td>
            <td>:</td>
            <td>{{ number_format($master->grand_total,0,',','.') }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Bayar</td>
            <td>:</td>
            <td>{{ number_format($master->terbayar,0,',','.') }}</td>
        </tr>
        <tr>
            <td class="font-weight-bold">Sisa</td>
            <td>:</td>
            <td>{{ number_format($master->sisa,0,',','.') }}</td>
        </tr>
    </table>

    <hr style="border-top:1px dotted black">
</body>

</html>
<script type="text/javascript">
    function PrintWindow() {
        window.print();
        // CheckWindowState();
    }

    function CheckWindowState() {
        if (document.readyState == "complete") {
            window.close();
        } else {
            setTimeout("CheckWindowState()", 10)
        }
    }
    PrintWindow();
</script>