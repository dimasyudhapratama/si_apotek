@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Data Produsen</b></h5>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / Produsen
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="alert_" class="alert alert-info alert-dismissible fade show" role="alert">
                            <b id="alert_messages_">&nbsp;</b>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        <button type="button" id="btnAddData" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#modal_"><i class="fa fa-plus"></i> Tambah Data Produsen</button>
                        <table class="table table-sm table-striped table-bordered" id="table_view">
                            <thead>
                                <tr>
                                    <td class="font-weight-bold text-center">No.</td>
                                    <td class="font-weight-bold text-center">Nama</td>
                                    <td class="font-weight-bold text-center">No. HP</td>
                                    <td class="font-weight-bold text-center">Email</td>
                                    <td class="font-weight-bold text-center">Bank</td>
                                    <td class="font-weight-bold text-center">No. Rekening</td>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form name="form_input" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"><b>Tambah Data Produsen</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="id_" id="id_">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Nama</label>
                            <input type="text" class="form-control form-control-sm" name="nama" id="nama" placeholder="Masukkan Nama" />
                        </div>
                        <div class="col-md-6">
                            <label for="">No. HP</label>
                            <input type="phone" class="form-control form-control-sm" name="no_hp" id="no_hp" placeholder="Masukkan No. HP" />
                        </div>
                        <div class="col-md-6">
                            <label for="">Email</label>
                            <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Masukkan Email" required/>
                        </div>
                        <div class="col-md-6">
                            <label for="">Bank</label>
                            <input type="text" class="form-control form-control-sm" name="bank" id="bank" placeholder="Masukkan Nama Bank" />
                        </div>
                        <div class="col-md-6">
                            <label for="">No Rekening</label>
                            <input type="text" class="form-control form-control-sm" name="no_rekening" id="no_rekening" placeholder="Masukkan No. Rekening" />
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnSave" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
                <!-- <input type="submit" id="btnSave" value=""> -->
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
        $("#alert_").hide();
    });
    
    //CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Add New Data
    $('#btnAddData').on('click',function(event){
        $("#ModalLabel").addClass("font-weight-bold")
        $("#ModalLabel").html('Tambah Data Produsen')
        emptyField();
    });

    //Save Data
    $('#btnSave').on('click', function(event) {
        event.preventDefault();
        $.ajax({
            url : "{{ route('produsen.store') }}",
            method : "POST",
            data : {
                'id_' : $("#id_").val(),
                'nama' : $("#nama").val(),
                'no_hp' : $("#no_hp").val(),
                'email' : $("#email").val(),
                'bank' : $("#bank").val(),
                'no_rekening' : $("#no_rekening").val()
            },
            success : function(ajaxData){
                //Empty Field
                emptyField()
                //Hide Modal
                $("#modal_").modal('hide');
                //Modifikasi Alert                
                if(ajaxData == "1"){
                    $("#alert_messages_").text('Input Data Berhasil');
                }else{
                    $("#alert_messages_").text('Input Data Gagal');
                }
                $("#alert_").show();
                //Reload Table
                loadDataTable();
            }
        });
    });

    //Empty Field
    function emptyField(){
        $("#id_").val("")
        $("#nama").val("")
        $("#no_hp").val("")
        $("#email").val("")
        $("#bank").val("")
        $("#no_rekening").val("")
    }

    //DataTable 
    function loadDataTable(){
        destroyDataTable();
        $("#table_view").DataTable({
            "responsive": true,
            "autoWidth": false,
            processing : true,
            serverSide : true,
            ajax : "{{ url('/produsen/data') }}",
            columns: [
                {render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }  
                },
                {data : 'nama'},
                {data : 'no_hp'},
                {data : 'email'},
                {data : 'bank'},
                {data : 'no_rekening'},
                { "className" : "text-center",
                    render: function (data, type, row, meta) {
                        var action_button = "<button class='btn btn-sm btn-primary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Aksi </button>"+
                                "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>"+
                                    "<a class='dropdown-item' href='#' onclick='edit("+row.id+")'>Edit</a>"+
                                    "<a class='dropdown-item' href='#' onclick='del("+row.id+")'>Delete</a>"+
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

    function edit(ProdusenID){
        $("#modal_").modal('show');
        $("#ModalLabel").addClass("font-weight-bold")
        $("#ModalLabel").html('Edit Data Produsen')
        $.ajax({
            type : "GET",
            url: "{{ url('produsen')}}"+"/"+ProdusenID+"/"+"edit",
            success: function (ajaxData) {
                $("#id_").val(ajaxData.id)
                $("#nama").val(ajaxData.nama)
                $("#no_hp").val(ajaxData.no_hp)
                $("#email").val(ajaxData.email)
                $("#bank").val(ajaxData.bank)
                $("#no_rekening").val(ajaxData.no_rekening)
            },
        });            
    }
    function del(ProdusenID){
        if(confirm('Anda Yakin Menghapus Data?')){
            $.ajax({
                type : "DELETE",
                url: "{{ url('produsen')}}"+'/'+ProdusenID,
                success: function (ajaxData) {
                    if(ajaxData == "1"){
                        $("#alert_messages_").text('Data Berhasil Dihapus');
                    }else{
                        $("#alert_messages_").text('Data Gagal Dihapus');
                    }
                    $("#alert_").show();
                    //Reload Table
                    loadDataTable();
                },
            });            
        }
    }
  </script>
@endsection