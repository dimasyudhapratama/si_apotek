@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Detail Laporan Pembelian ({{ $data_return_pembelian->id }})</b></h5>
                        <div class="card-tools">
                            <a href="{{ url('/') }}">Home</a> / Detail Laporan Return Pembelian
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool " data-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a class='dropdown-item' href='#' onclick='cetakStrukPenjualan( "58mm","{{$data_return_pembelian->id}}" )'>Cetak (58mm)</a>
                                    <a class='dropdown-item' href='#' onclick='cetakStrukPenjualan( "a4","{{$data_return_pembelian->id}}" )'>Cetak (A4)</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="alert_" class="alert alert-info alert-dismissible fade show" role="alert">
                            <b id="alert_messages_">&nbsp;</b>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <small class="font-weight-bold">Tanggal - Waktu</small>
                                <input type="text" name="tanggal_pembelian" id="tanggal_pembelian" class="form-control-plaintext" value="{{ $data_return_pembelian->created_at }}" disabled>
                            </div>
                            <div class="col-md-2">
                                <small class="font-weight-bold">Supplier</small>
                                <input type="text" name="supplier" id="supplier" class="form-control-plaintext" value="{{ $data_return_pembelian->nama_supplier }}" disabled>
                            </div> 
                            
                            <div class="col-md-2">
                                <small class="font-weight-bold">Status</small>
                                <br>
                                @if($data_return_pembelian->status_pembayaran == "1")
                                <span class="badge badge-success">Lunas</span>
                                @elseif($data_return_pembelian->status_pembayaran == "0")
                                <span class="badge badge-warning">Belum Lunas</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <small class="font-weight-bold">Total</small>
                                <input type="text" name="total" id="total" class="form-control-plaintext" value="Rp. {{ number_format($data_return_pembelian->total,0,',','.') }}" disabled>
                            </div>
                            <div class="col-md-2">
                                <small class="font-weight-bold">Diskon</small>
                                <input type="text" name="diskon_idr" id="diskon_idr" class="form-control-plaintext" value="Rp. {{ number_format($data_return_pembelian->diskon,0,',','.') }}" disabled>
                            </div>
                            <div class="col-md-2">
                                <small class="font-weight-bold">Grand Total</small>
                                <input type="text" name="grand_total" id="grand_total" class="form-control-plaintext" value="Rp. {{ number_format($data_return_pembelian->grand_total,0,',','.') }}" disabled>
                            </div>
                            <div class="col-md-2">
                                <small class="font-weight-bold">Terbayar</small>
                                <input type="text" name="terbayar" id="terbayar" class="form-control-plaintext" value="Rp. {{ number_format($data_return_pembelian->terbayar,0,',','.') }}" disabled>
                            </div>
                            <div class="col-md-2">
                                <small class="font-weight-bold">Sisa Tunggakan</small>
                                <input type="text" name="sisa" id="sisa" class="form-control-plaintext" value="Rp. {{ number_format($data_return_pembelian->sisa_tunggakan,0,',','.') }}" disabled>
                            </div>
                            
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <small class="font-weight-bold font-italic">Detail Pembelian</small>
                                <table class="table table-striped table-bordered table-sm mt-2">
                                    <thead>
                                        <tr>
                                            <td class="text-center font-weight-bold">No.</td>
                                            <td class="text-center font-weight-bold">Kode</td>
                                            <td class="text-center font-weight-bold">Nama</td>
                                            <td class="text-center font-weight-bold">Satuan</td>
                                            <td class="text-center font-weight-bold">Harga</td>
                                            <td class="text-center font-weight-bold">Qty</td>
                                            <td class="text-center font-weight-bold">Subtotal</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1 @endphp
                                        @foreach($detail as $i)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $i->produk_id }}</td>
                                            <td>{{ $i->nama_produk }}</td>
                                            <td>{{ $i->satuan }}</td>
                                            <td class="text-right">Rp. {{ number_format($i->harga,0,',','.') }}</td>
                                            <td>{{ $i->qty }}</td>
                                            <td class="text-right">Rp. {{ number_format($i->subtotal,0,',','.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <p class="font-weight-bold">Data Pembayaran</p>
                            </div>
                            <div class="col-md-9 float-right">
                                <div class="float-right">
                                    <button class="btn btn-sm btn-primary" id="btnTambahPembayaran" data-toggle="modal" data-target="#modal_"><i class="fa fa-plus"></i> Tambah Pembayaran</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-sm" id="table-pembayaran">
                                    <thead>
                                        <tr>
                                            <td class="text-center font-weight-bold">No.</td>
                                            <td class="text-center font-weight-bold">Tanggal Pembayaran</td>
                                            <td class="text-center font-weight-bold">Jumlah</td>
                                            <td class="text-center font-weight-bold">Operator</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="modal fade" id="modal_" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form name="form_input" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"><b>Tambah Data Pembayaran</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="return_pembelian_id" id="return_pembelian_id" value="{{$data_return_pembelian->id}}">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Tanggal</label>
                            <input type="date" name="data_pembayaran_tanggal" id="data_pembayaran_tanggal" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-6">
                            <label for="">Jumlah</label>
                            <input type="number" class="form-control form-control-sm" name="data_pembayaran_jumlah" id="data_pembayaran_jumlah" placeholder="Masukkan Jumlah" />
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnSimpanPembayaran" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('konten_js')
<script>
    //Initialization - Loaded First
    $(function () {
        $("#alert_").hide();
        loadDataPembayaran();
    });
    
    //CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#btnTambahPembayaran').on('click',function(event){
        emptyModalPembayaran();
    });
    
    $('#btnSimpanPembayaran').on('click',function(event){
        event.preventDefault();
        $.ajax({
            url : "{{ url('/return_pembelian/simpanPembayaran') }}",
            method : "POST",
            data : {
                'return_pembelian_id' : $("#return_pembelian_id").val(),
                'data_pembayaran_tanggal' : $("#data_pembayaran_tanggal").val(),
                'data_pembayaran_jumlah' : $("#data_pembayaran_jumlah").val()
            },
            success : function(ajaxData){
                //Empty Field
                emptyModalPembayaran()
                //Hide Modal
                $("#modal_").modal('hide');
                //Reload Table
                loadDataPembayaran();
            }
        });
        emptyModalPembayaran();
    });

    function emptyModalPembayaran(){
        $("#data_pembayaran_tanggal").val("");
        $("#data_pembayaran_jumlah").val("");
    }

    //DataTable 
    function loadDataPembayaran(){
        destroyDataTable();
        $("#table-pembayaran").DataTable({
            "responsive": true,
            "autoWidth": false,
            processing : true,
            serverSide : true,
            ajax : "{{ url('/detail_return_pembelian/pembayaran') }}"+"/{{ $data_return_pembelian->id }}",
            columns: [
                {render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }  
                },
                {data : 'created_at'},
                {"className" : "text-right",
                    render: function (data, type, row, meta) {
                        return formatRupiah(row.jumlah);
                    }  
                },
                { "className" : "text-center",
                    render: function (data, type, row, meta) {
                        var action_button = "<button class='btn btn-sm btn-primary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Aksi </button>"+
                                "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>"+
                                    "<a class='dropdown-item' href='#' onclick='printKwitansiPembayaran("+row.id+")'>Cetak</a>"+
                                    "<a class='dropdown-item' href='#' onclick='del("+row.id+")'>Delete</a>"+
                                "</div>";
                        return action_button;
                    }  
                },
            ],
        });
    }
    function destroyDataTable(){
        if ($.fn.DataTable.isDataTable('#table-pembayaran')) {
            $('#table-pembayaran').DataTable().destroy();
        }
        $('#table-pembayaran tbody').empty();
    }

    function formatRupiah(angka){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return "Rp." + rupiah;
    }
</script>
@endsection