@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Riwayat Sistem</b></h5>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / Riwayat Sistem
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-striped table-bordered" id="table_view">
                            <thead>
                                <tr>
                                    <td class="font-weight-bold text-center" style="width:5%">No.</td>
                                    <td class="font-weight-bold text-center" style="width:15%">Datetime</td>
                                    <td class="font-weight-bold text-center">Keterangan</td>
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
            "order": [[ 1, 'desc' ]],
            "responsive": true,
            "autoWidth": false,
            processing : true,
            serverSide : true,
            ajax : "{{ url('/riwayat/data') }}",
            columns: [
                {render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }  
                },
                {data : 'created_at'},
                {data : 'keterangan'},
            ],
        });
    }
    function destroyDataTable(){
        if ($.fn.DataTable.isDataTable('#table_view')) {
            $('#table_view').DataTable().destroy();
        }
    }
  </script>
@endsection