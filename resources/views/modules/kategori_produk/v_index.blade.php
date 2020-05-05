@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Data Kategori Produk</b></h5>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / Kategori Produk
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="alert_" class="alert alert-info alert-dismissible fade show" role="alert">
                            <b id="alert_messages_">&nbsp;</b>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        <button type="button" id="btnAddData" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#modal_"><i class="fa fa-plus"></i> Tambah Data Kategori Produk</button>
                        <table class="table table-sm table-striped table-bordered" id="table_view">
                            <thead>
                                <tr>
                                    <td class="font-weight-bold text-center">No.</td>
                                    <td class="font-weight-bold text-center">Nama Kategori</td>
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
                <h5 class="modal-title" id="ModalLabel"><b>Tambah Data Kategori Produk</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="id_" id="id_">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Nama Kategori</label>
                            <input type="text" class="form-control form-control-sm" name="nama" id="nama" placeholder="Masukkan Nama" />
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnSave" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
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
        $("#ModalLabel").html('Tambah Data Kategori Produk')
        emptyField();
    });

    //Save Data
    $('#btnSave').on('click', function(event) {
        event.preventDefault();
        $.ajax({
            url : "{{ route('kategori_produk.store') }}",
            method : "POST",
            data : {
                'id_' : $("#id_").val(),
                'nama' : $("#nama").val()
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
    }

    //DataTable 
    function loadDataTable(){
        destroyDataTable();
        $("#table_view").DataTable({
            "responsive": true,
            "autoWidth": false,
            processing : true,
            serverSide : true,
            ajax : "{{ url('/kategori_produk/data') }}",
            columns: [
                {render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }  
                },
                {data : 'nama_kategori'},
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

    function edit(KategoriProdukID){
        $("#modal_").modal('show');
        $("#ModalLabel").addClass("font-weight-bold")
        $("#ModalLabel").html('Edit Data Kategori Produk')
        $.ajax({
            type : "GET",
            url: "{{ url('kategori_produk')}}"+"/"+KategoriProdukID+"/"+"edit",
            success: function (ajaxData) {
                $("#id_").val(ajaxData.id)
                $("#nama").val(ajaxData.nama_kategori)
            },
        });            
    }
    function del(KategoriProdukID){
        if(confirm('Anda Yakin Menghapus Data?')){
            $.ajax({
                type : "DELETE",
                url: "{{ url('kategori_produk')}}"+'/'+KategoriProdukID,
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