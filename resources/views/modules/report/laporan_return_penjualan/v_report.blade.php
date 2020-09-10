@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Laporan Return Penjualan</b></h5>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / Laporan Return Penjualan
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="alert_" class="alert alert-info alert-dismissible fade show" role="alert">
                            <b id="alert_messages_">&nbsp;</b>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        <button type="button" id="btnFilter" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#modal_"><i class="fa fa-filter"></i> Filter</button>
                        <table class="table table-sm table-striped table-bordered" id="table_view">
                            <thead>
                                <tr>
                                    <td class="font-weight-bold text-center">No.</td>
                                    <td class="font-weight-bold text-center">No. Return</td>
                                    <td class="font-weight-bold text-center">No. Nota</td>
                                    <td class="font-weight-bold text-center">Tanggal</td>
                                    <td class="font-weight-bold text-center">Dokter</td>
                                    <td class="font-weight-bold text-center">Customer</td>
                                    <td class="font-weight-bold text-center">Grand Total</td>
                                    <td class="font-weight-bold text-center">Status</td>
                                    <td class="font-weight-bold text-center">Op.</td>
                                    <td class="font-weight-bold text-center">Aksi</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- Modal -->
<div class="modal fade" id="modal_" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form name="form_input" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"><b>Filter</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="">Tipe Pencarian</label>
                            <select name="tipe_pencarian" id="tipe_pencarian" class="form-control form-control-sm">
                                <option value="0">Semua</option>
                                <option value="1">Harian</option>
                                <option value="2">Bulanan</option>
                                <option value="3">Tahunan</option>
                                <option value="4">Custom</option>
                            </select>
                        </div>
                        <div class="col-md-3" id="tanggal_x">
                            <label for="">Tanggal</label>
                            <select name="tanggal" id="tanggal" class="form-control form-control-sm">
                                @php $tanggal = 1 @endphp
                                @for($tanggal=1;$tanggal<=31;$tanggal++)
                                <option value="{{$tanggal}}">{{$tanggal}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3" id="bulan_x">
                            <label for="">Bulan</label>
                            <select name="tahun" id="bulan" class="form-control form-control-sm">
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-3" id="tahun_x">
                            <label for="">Tahun</label>
                            <select name="tahun" id="tahun" class="form-control form-control-sm">
                                @php $thisYear = date('Y') @endphp
                                @for($i=$thisYear;$i>=2019;$i--)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-3" id="tanggal_awal_x">
                            <label for="">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3" id="tanggal_akhir_x">
                            <label for="">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control form-control-sm">
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnLoadDatatableWithParameter" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
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
        loadDataTable();
        checkTipePencarian()
        $("#alert_").hide()
    });
    
    //CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#tipe_pencarian').on('change', function(event) {
        checkTipePencarian()
    });

    //Save Data
    $('#btnLoadDatatableWithParameter').on('click', function(event) {
        event.preventDefault()
        loadDataTable()
        $("#modal_").modal('hide')
    });

    function checkTipePencarian(){
        var tipe_pencarian = $("#tipe_pencarian").find(":selected").val()        
        
        $("#tanggal_x").hide()
        $("#bulan_x").hide()
        $("#tahun_x").hide()
        $("#tanggal_awal_x").hide()
        $("#tanggal_akhir_x").hide()

        if(tipe_pencarian == 1){
            $("#tanggal_x").show()
            $("#bulan_x").show()
            $("#tahun_x").show()
        }else if(tipe_pencarian == 2){
            $("#bulan_x").show()
            $("#tahun_x").show()
        }else if(tipe_pencarian == 3){
            $("#tahun_x").show()
        }else if(tipe_pencarian == 4){
            $("#tanggal_awal_x").show()
            $("#tanggal_akhir_x").show()
            
        }
    }

    //DataTable 
    function loadDataTable(){
        destroyDataTable();
        $("#table_view").DataTable({
            "responsive": true,
            "autoWidth": false,
            processing : true,
            serverSide : true,
            order:[2,"desc"],
            ajax : { 
                url : "{{ url('/laporan_return_penjualan/data') }}",
                type : "post",
                data : {
                    tipe_pencarian : $("#tipe_pencarian").find(":selected").val(),
                    tanggal : $("#tanggal").find(":selected").val(),
                    bulan : $("#bulan").find(":selected").val(),
                    tahun : $("#tahun").find(":selected").val(),
                    tanggal_awal : $("#tanggal_awal").val(),
                    tanggal_akhir : $("#tanggal_akhir").val(),
                    status_pembayaran : $("#status_pembayaran").find(":selected").val()
                },
            },
            columns: [
                {render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }  
                },
                {data : 'id'},
                {data : 'penjualan_id'},
                {data : 'created_at'},
                {data : 'nama_dokter'},
                {data : 'nama_customer'},
                { "className" : "text-right", "orderable": false,
                    render: function (data, type, row, meta) {
                        return formatRupiah(row.grand_total)
                    }  
                },
                { "className" : "text-center",
                    render: function (data, type, row, meta) {
                        return row.status_pembayaran == "1" ? "<span class='badge badge-success'>Lunas</span>" : "<span class='badge badge-warning'>Belum Lunas</span>";
                    }  
                },
                {data : 'name'},
                { "className" : "text-center", "orderable": false,
                    render: function (data, type, row, meta) {
                        var id = row.id;
                        var action_button = "<button class='btn btn-sm btn-primary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Aksi </button>"+
                                "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>"+
                                    '<a class="dropdown-item" href="#" onclick="detail(\''+id+ '\')">Detail</a>'+
                                    '<a class="dropdown-item" href="#" onclick="del(\''+id+ '\')">Delete</a>'+
                                "</div>";
                        return action_button;
                    }  
                },
            ],
        });
    }
    function destroyDataTable(){
        if ($.fn.DataTable.isDataTable('#table_view')) {
            $('#table_view').DataTable().destroy();
        }
        $('#table_view tbody').empty();
    }

    function detail(transaksiID){
        window.open("{{ url('detail_return_penjualan') }}"+"/"+transaksiID,"_self")
    }

    
    function del(transaksiID){
        // if(confirm('Anda Yakin Menghapus Data?')){
        //     $.ajax({
        //         type : "DELETE",
        //         url: "{{ url('customer')}}"+'/'+CustomerID,
        //         success: function (ajaxData) {
        //             if(ajaxData == "1"){
        //                 $("#alert_messages_").text('Data Berhasil Dihapus');
        //             }else{
        //                 $("#alert_messages_").text('Data Gagal Dihapus');
        //             }
        //             $("#alert_").show();
        //             //Reload Table
        //             loadDataTable();
        //         },
        //     });            
        // }
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