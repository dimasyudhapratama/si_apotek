@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Laporan Koreksi Stok</b></h5>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / Laporan Koreksi Stok
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="alert_" class="alert alert-info alert-dismissible fade show" role="alert">
                            <b id="alert_messages_">&nbsp;</b>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        <table class="table table-sm table-striped table-bordered" id="table_view">
                            <thead>
                                <tr>
                                    <td class="font-weight-bold text-center">No.</td>
                                    <td class="font-weight-bold text-center">No. Koreksi</td>
                                    <td class="font-weight-bold text-center">Keterangan</td>
                                    <td class="font-weight-bold text-center">Datetime</td>
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
@endsection

@section('konten_js')
<script>
    //Initialization - Loaded First
    $(function () {
        loadDataTable();
        $("#alert_").hide()
    });
    
    //CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
                url : "{{ url('/laporan_koreksi_stok/data') }}",
                type : "post",
            },
            columns: [
                {render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }  
                },
                {data : 'id'},
                {data : 'keterangan'},
                {data : 'created_at'},
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
        window.open("{{ url('detail_koreksi_stok') }}"+"/"+transaksiID,"_self")
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
  </script>
@endsection