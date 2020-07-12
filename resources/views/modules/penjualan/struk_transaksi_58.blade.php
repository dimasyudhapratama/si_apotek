<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Struk Penjualan 58</title>
    <style type="text/css" media="print">
        @page {
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
        }
    </style>
</head>

<body>
    <h6 style="margin-top:0px;font-weight:bold">APOTEK KARTINI MAS MANDIRI</h6>
    <h6 style="margin-top:-25px;">Jl. Raya Gedang Mas</h6>
    <h6 style="margin-top:-25px;">Randuagung, Telp. 0334-322181</h6>
    <h6 style="margin-top:-25px;">Lumajang - Jatim</h6>

    <!-- Data Master Transaksi -->
    <table style="margin-top:-20px;">
        <!-- Pasien -->
        <tr>
            <td>No.Resep</td>
            <td>:</td>
            <td>{{ $master_penjualan->id }}</td>
        </tr>
        <tr>
            <td>Dokter</td>
            <td>:</td>
            <td>{{ $master_penjualan->nama_dokter != NULL ? $master_penjualan->nama_dokter : '-'   }}</td>
        </tr>
        <tr>
            <td>Customer</td>
            <td>:</td>
            <td>{{ $master_penjualan->nama_customer != NULL ? $master_penjualan->nama_customer : '-'   }}</td>
        </tr>
        <tr>
            <td>Tgl/Jam</td>
            <td>:</td>
            <td>{{ date("d-m-Y H:i",strtotime($master_penjualan->created_at)) }}</td>
        </tr>
    </table>

    <hr style="border-top:1px dotted black">
    
    <!-- Data Detail Transaksi -->
    <table style="width:100%">
        @foreach($detail_penjualan as $detail)
        <tr>
            <td colspan="3">{{ $detail->nama_produk }}</td>
        </tr>
        <tr>
            <td style="width:10%">{{ $detail->qty }}X</td>
            <td style="width:40%;text-align:right">{{ number_format($detail->harga,0,',','.') }}</td>
            <td style="text-align:right;width:50%">{{ number_format($detail->subtotal,0,',','.') }}</td>
        </tr>
        @endforeach
    </table>
    
    <!-- Data Master Transaksi -->
    <table style="margin-top:10px;">
        <!-- Pasien -->
        <tr>
            <td>Total</td>
            <td>:</td>
            <td>{{ number_format($master_penjualan->total,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Diskon</td>
            <td>:</td>
            <td>{{ number_format($master_penjualan->diskon,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Grand Total</td>
            <td>:</td>
            <td>{{ number_format($master_penjualan->grand_total,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td>:</td>
            <td>{{ number_format($master_penjualan->uang_pembayaran,0,',','.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td>:</td>
            <td>{{ number_format($master_penjualan->kembalian_pembayaran,0,',','.') }}</td>
        </tr>
    </table>

    <hr style="border-top:1px dotted black">

    <p style="text-align:center;">" Terima Kasih "</p>
    <p style="text-align:center">Barang Yang Sudah Dibeli Tidak Dapat Ditukar / Dikembalikan</p>
</body>

</html>
<script type="text/javascript">
    function PrintWindow() {
        window.print();
        CheckWindowState();
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