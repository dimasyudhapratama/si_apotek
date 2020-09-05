@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Komisi Dokter</b></h5>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / Komisi Dokter
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Belum tau presentasi pembagian per resep</p>
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
                                    <td class="font-weight-bold text-center" style="width:5%">No.</td>
                                    <td class="font-weight-bold text-center">Dokter</td>
                                    <td class="font-weight-bold text-center">Jumlah</td>
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
                        <div class="col-md-2">
                            <small class="font-weight-bold">Dokter</small>
                            <select name="dokter" id="dokter" class="form-control form-control-sm">
                                <option value="">Semua Data</option>
                                @foreach($dokter as $i)
                                <option value="{{$i->id}}">{{$i->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <small class="font-weight-bold">Tipe Pencarian</small>
                            <select name="tipe_pencarian" id="tipe_pencarian" class="form-control form-control-sm">
                                <option value="0">Semua Data</option>
                                <option value="1">Harian</option>
                                <option value="2">Bulanan</option>
                                <option value="3">Tahunan</option>
                                <option value="4">Custom</option>
                            </select>
                        </div>
                        <div class="col-md-2" id="tanggal_x">
                            <small class="font-weight-bold">Tanggal</small>
                            <select name="tanggal" id="tanggal" class="form-control form-control-sm">
                                @php $tanggal = 1 @endphp
                                @for($tanggal=1;$tanggal<=31;$tanggal++)
                                <option value="{{$tanggal}}">{{$tanggal}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2" id="bulan_x">
                            <small class="font-weight-bold">Bulan</small>
                            <select name="bulan" id="bulan" class="form-control form-control-sm">
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
                        <div class="col-md-2" id="tahun_x">
                            <small class="font-weight-bold">Tahun</small>
                            <select name="tahun" id="tahun" class="form-control form-control-sm">
                                @php $thisYear = date('Y') @endphp
                                @for($i=$thisYear;$i>=2019;$i--)
                                <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2" id="tanggal_awal_x">
                            <small class="font-weight-bold">Tanggal Awal</small>
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2" id="tanggal_akhir_x">
                            <small class="font-weight-bold">Tanggal Akhir</small>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control form-control-sm">
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnLoadDatatableWithParameter" class="btn btn-primary btn-sm"><i class="fa fa-calculator"></i>  Hitung</button>
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
        checkTipePencarian()
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
                url : "{{ url('/laporan_pembelian/data') }}",
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
                {data : 'created_at'},
                {data : 'nama'},
                {data : 'cara_pembayaran'},
                {data : 'tgl_jatuh_tempo'},
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
  </script>
@endsection