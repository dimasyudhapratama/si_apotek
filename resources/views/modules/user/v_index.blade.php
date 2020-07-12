@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Data User</b></h5>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / User
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="alert_" class="alert alert-info alert-dismissible fade show" role="alert">
                            <b id="alert_messages_">&nbsp;</b>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        <button type="button" id="btnAddData" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#modal_add_user"><i class="fa fa-plus"></i> Tambah Data User</button>
                        <table class="table table-sm table-striped table-bordered" id="table_view">
                            <thead>
                                <tr>
                                    <td class="font-weight-bold text-center">No.</td>
                                    <td class="font-weight-bold text-center">Nama</td>
                                    <td class="font-weight-bold text-center">Username (Login)</td>
                                    <td class="font-weight-bold text-center">Roles</td>
                                    <td class="font-weight-bold text-center">Status</td>
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
<div class="modal fade" id="modal_add_user" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form name="form_input" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"><b>Tambah Data User</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Nama</label>
                        <input type="text" class="form-control form-control-sm" name="nama" id="nama_a" placeholder="Masukkan Nama" />
                    </div>
                    <div class="col-md-6">
                        <label for="">Username (Login)</label>
                        <input type="text" class="form-control form-control-sm" name="username" id="username_a" placeholder="Masukkan Username" />
                    </div>
                    <div class="col-md-6">
                        <label for="">Roles</label>
                        <select name="roles" id="roles_a" class="form-control form-control-sm">
                            <option value="">--Pilih--</option>
                            <option value="Manager">Manager</option>
                            <option value="Kasir">Kasir</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">Status</label>
                        <select name="status" id="status_a" class="form-control form-control-sm">
                            <option value="">--Pilih--</option>
                            <option value="1">Aktif</option>
                            <option value="0">Non Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <label for="">Password</label>    
                        <input id="password_a" type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password_" required autocomplete="new-password">
                    </div>
                    <div class="col-md-6">
                        <label for="">Konfirmasi Password</label>    
                        <input id="password_confirmation_a" type="password" class="form-control form-control-sm" name="password_confirmation" required autocomplete="new-password">
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
<div class="modal fade" id="modal_edit_user" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form name="form_input" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"><b>Edit Data User</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_" id="id_e">
                <div class="row">
                    <div class="col-md-6">
                        <label for="">Nama</label>
                        <input type="text" class="form-control form-control-sm" name="nama" id="nama_e" placeholder="Masukkan Nama" />
                    </div>
                    <div class="col-md-6">
                        <label for="">Username (Login)</label>
                        <input type="text" class="form-control form-control-sm" name="username" id="username_e" placeholder="Masukkan Username" />
                    </div>
                    <div class="col-md-6">
                        <label for="">Roles</label>
                        <select name="roles" id="roles_e" class="form-control form-control-sm">
                            <option value="">--Pilih--</option>
                            <option value="Manager">Manager</option>
                            <option value="Kasir">Kasir</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="">Status</label>
                        <select name="status" id="status_e" class="form-control form-control-sm">
                            <option value="">--Pilih--</option>
                            <option value="1">Aktif</option>
                            <option value="0">Non Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnUpdate" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_edit_password" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form name="form_input" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"><b>Edit Password</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <input type="text" name="id_" id="id_ep">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Password</label>    
                            <input id="password_ep" type="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password_" required autocomplete="new-password">
                        </div>
                        <div class="col-md-6">
                            <label for="">Konfirmasi Password</label>    
                            <input id="password_confirmation_ep" type="password" class="form-control form-control-sm" name="password_confirmation" required autocomplete="new-password">
                            <small id="info_ep" class="text-danger"></small>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="btnUpdatePassword" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Simpan</button>
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
        $("#ModalLabel").html('Tambah Data User')
        //Empty Field
        $("#id_a").val("")
        $("#nama_a").val("")
        $("#username_a").val("")
        $("#roles_a").val("")
        $("#status_a").val("")
        $("#password_a").val("")
        $("#password_confirmation_a").val("")
    });

    //Save Data
    $('#btnSave').on('click', function(event) {
        event.preventDefault();
        //Validasi Dulu
        /////////////
        $.ajax({
            url : "{{ url('/user/store') }}",
            method : "POST",
            data : {
                'id_' : $("#id_a").val(),
                'nama' : $("#nama_a").val(),
                'username' : $("#username_a").val(),
                'roles' : $("#roles_a").val(),
                'status' : $("#status_a").val(),
                'password_' : $("#password_a").val(),
            },
            success : function(ajaxData){
                //Empty Field
                $("#nama_a").val("")
                $("#username_a").val(""),
                $("#roles_a").val("")
                $("#status_a").val("")
                $("#password_a").val("")
                $("#password_confirmation_a").val("")
                //Hide Modal
                $("#modal_add_user").modal('hide');
                //Modifikasi Alert                
                if(ajaxData == "1"){
                    $("#alert_messages_").text('Berhasil');
                }else{
                    $("#alert_messages_").text('Gagal');
                }
                $("#alert_").show();
                //Reload Table
                loadDataTable();
            }
        });
    });

    //Edit Data
    function edit(UserID){
        $("#modal_edit_user").modal('show');
        $.ajax({
            type : "GET",
            url: "{{ url('/user/edit')}}"+"/"+UserID,
            success: function (ajaxData) {
                $("#id_e").val(ajaxData.id)
                $("#nama_e").val(ajaxData.name)
                $("#username_e").val(ajaxData.username)
                $("#roles_e").val(ajaxData.roles)
                $("#status_e").val(ajaxData.status)
            },
        });            
    }

    //Update Data
    $('#btnUpdate').on('click', function(event) {
        event.preventDefault();
        //Validasi Dulu
        /////////////
        $.ajax({
            url : "{{ url('/user/update') }}",
            method : "POST",
            data : {
                'id_' : $("#id_e").val(),
                'nama' : $("#nama_e").val(),
                'username' : $("#username_e").val(),
                'roles' : $("#roles_e").val(),
                'status' : $("#status_e").val(),
            },
            success : function(ajaxData){
                //Empty Field
                $("#id_e").val("")
                $("#nama_e").val("")
                $("#username_e").val("")
                $("#roles_e").val("")
                $("#status_e").val("")
                //Hide Modal
                $("#modal_edit_user").modal('hide');
                //Modifikasi Alert                
                if(ajaxData == "1"){
                    $("#alert_messages_").text('Berhasil');
                }else{
                    $("#alert_messages_").text('Gagal');
                }
                $("#alert_").show();
                //Reload Table
                loadDataTable();
            }
        });
    });

    //Edit Password
    function editPassword(UserID){
        $("#modal_edit_password").modal('show');
        $("#password_confirmation_ep").removeClass("is-invalid");
        $("#info_ep").text("");

        $("#id_ep").val(UserID)
        $("#password_ep").val("")
        $("#password_confirmation_ep").val("")
    }

    //Update Password
    $('#btnUpdatePassword').on('click', function(event) {
        event.preventDefault();
        //Validasi Dulu
        if($("#password_ep").val() != $("#password_confirmation_ep").val()){
            $("#password_confirmation_ep").addClass("is-invalid");
            $("#info_ep").text("Password Tidak Sama");
        }else{
            $.ajax({
                url : "{{ url('/user/update_password') }}",
                method : "POST",
                data : {
                    'id_' : $("#id_ep").val(),
                    'password_' : $("#password_ep").val(),
                    'password_confirmation' : $("#password_confirmation_ep").val(),
                },
                success : function(ajaxData){
                    //Empty Field
                    $("#password_confirmation_ep").removeClass("is-invalid");
                    $("#info_ep").text("");

                    $("#id_ep").val("")
                    $("#password_ep").val("")
                    $("#password_confirmation_ep").val("")
                    
                    //Hide Modal
                    $("#modal_edit_password").modal('hide');
                    //Modifikasi Alert                
                    if(ajaxData == "1"){
                        $("#alert_messages_").text('Berhasil');
                    }else{
                        $("#alert_messages_").text('Gagal');
                    }
                    $("#alert_").show();
                    //Reload Table
                    loadDataTable();
                }
            });
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
            ajax : "{{ url('/user/data') }}",
            columns: [
                {render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }  
                },
                {data : 'name'},
                {data : 'username'},
                {data : 'roles'},
                { "className" : "text-center",
                    render: function (data, type, row, meta) {
                        var action_button = "";
                        if(row.status == 0){
                            action_button = "<span class='badge badge-danger'>Non Aktif</badge>"
                        }else if(row.status == 1){
                            action_button = "<span class='badge badge-primary'>Aktif</badge>"
                        }
                        return action_button;
                    }  
                },
                { "className" : "text-center",
                    render: function (data, type, row, meta) {
                        var action_button = "<button class='btn btn-sm btn-primary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Aksi </button>"+
                                "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>"+
                                    "<a class='dropdown-item' href='#' onclick='edit("+row.id+")'>Edit</a>"+
                                    "<a class='dropdown-item' href='#' onclick='editPassword("+row.id+")'>Ubah Password</a>"+
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
  </script>
@endsection