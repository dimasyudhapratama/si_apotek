@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Data Produk</b></h5>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / Produk
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="alert_" class="alert alert-info alert-dismissible fade show" role="alert">
                            <b id="alert_messages_">&nbsp;</b>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        <button type="button" id="btnAddData" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#modal_"><i class="fa fa-plus"></i> Tambah Data Produk</button>
                        <table class="table table-sm table-striped table-bordered" id="table_view">
                            <thead>
                                <tr>
                                    <td class="font-weight-bold text-center">No.</td>
                                    <td class="font-weight-bold text-center">Kategori</td>
                                    <td class="font-weight-bold text-center">Kode</td>
                                    <td class="font-weight-bold text-center">Nama Produk</td>
                                    <td class="font-weight-bold text-center">Stok Minimal</td>
                                    <td class="font-weight-bold text-center">Status Pajak</td>
                                    <td class="font-weight-bold text-center">Produsen</td>
                                    <td class="font-weight-bold text-center">Supplier</td>
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
                <h5 class="modal-title" id="ModalLabel"><b>Tambah Data Produk</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <small class="font-weight-bold">Kode Produk</small>
                        <input type="hidden" name="id_" id="id_" class="form-control form-control-sm">
                        <input type="text" name="kode_produk" id="kode_produk" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">
                        <small class="font-weight-bold">Nama Kategori</small>
                        <select name="kategori" id="kategori" class="form-control form-control-sm">
                            <option value="">--Pilih--</option>
                            @foreach($kategori_produk as $i)
                            <option value="{{ $i->id }}">{{ $i->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <small class="font-weight-bold">Nama Produk</small>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">
                        <small class="font-weight-bold">Stok Minimal</small>
                        <input type="number" name="stok_minimal" id="stok_minimal" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">
                        <small class="font-weight-bold">Harga Beli</small>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control form-control-sm" value="0" onkeyup="ubahHargaBeli()">
                    </div>
                    <div class="col-md-4">
                        <small class="font-weight-bold">Produsen</small>
                        <select name="produsen" id="produsen" class="form-control form-control-sm">
                            <option value="">--Pilih--</option>
                            @foreach($produsen as $i)
                            <option value="{{ $i->id }}">{{ $i->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <small class="font-weight-bold">Supplier</small>
                        <select name="supplier" id="supplier" class="form-control form-control-sm">
                            <option value="">--Pilih--</option>
                            @foreach($supplier as $i)
                            <option value="{{ $i->id }}">{{ $i->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <small class="font-weight-bold">Level Satuan</small>
                        <select name="level_satuan" id="level_satuan" class="form-control form-control-sm" onchange="ubahLevelSatuan()">
                            <option value="1">Level 1</option>
                            <option value="2">Level 2</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <small class="font-weight-bold">Margin Pajak(10%)</small>
                        <select name="margin_pajak" id="margin_pajak" class="form-control form-control-sm" onchange="ubahHargaBeli()">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <hr>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <small class="font-weight-bold">Tipe Satuan</small>
                    </div>
                    <div class="col-md-2">
                        <small class="font-weight-bold">Nilai Konversi</small>
                    </div>
                    <div class="col-md-2">
                        <small class="font-weight-bold">Margin Biasa(%)</small>
                    </div>
                    <div class="col-md-2">
                    <small class="font-weight-bold">Harga Biasa</small>
                    </div>
                    <div class="col-md-2">
                        <small class="font-weight-bold">Margin Resep(%)</small>
                    </div>
                    <div class="col-md-2">
                        <small class="font-weight-bold">Harga Resep</small>
                    </div>
                </div>
                    <!-- Level 1 -->
                <div class="row mt-1">
                    <input type="hidden" name="id_konversi" id="id_konversi_1">
                    <div class="col-md-2">
                        <select name="satuan_jual" id="satuan_jual_1" class="form-control form-control-sm">
                            <option value="Dus">Dus</option>
                            <option value="Botol">Botol</option>
                            <option value="Strip">Strip</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Vial">Vial</option>
                            <option value="Tubes">Tubes</option>
                            <option value="Ampul">Ampul</option>
                            <option value="Capsule">Capsule</option>
                            <option value="Box">Box</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="nilai_konversi" id="nilai_konversi_1" class="form-control form-control-sm" value="1" min="1" onkeyup="ubahHargaBeli()">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="margin_biasa" id="margin_biasa_1" class="form-control form-control-sm" value="0" onkeyup="ubahHargaBeli()">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="harga_biasa" id="harga_biasa_1" class="form-control form-control-sm" value="0">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="margin_resep" id="margin_resep_1" class="form-control form-control-sm" value="0" onkeyup="ubahHargaBeli()">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="harga_resep" id="harga_resep_1" class="form-control form-control-sm" value="0">
                    </div>
                </div>
                    <!-- Level 2 -->
                <div class="row mt-1">
                    <input type="hidden" name="id_konversi" id="id_konversi_2">
                    <div class="col-md-2">
                        <select name="satuan_jual" id="satuan_jual_2" class="form-control form-control-sm">
                            <option value="Dus">Dus</option>
                            <option value="Botol">Botol</option>
                            <option value="Strip">Strip</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Vial">Vial</option>
                            <option value="Tubes">Tubes</option>
                            <option value="Ampul">Ampul</option>
                            <option value="Capsule">Capsule</option>
                            <option value="Box">Box</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="nilai_konversi" id="nilai_konversi_2" class="form-control form-control-sm" value="1" min="1" onkeyup="ubahHargaBeli()">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="margin_biasa" id="margin_biasa_2" class="form-control form-control-sm" value="0" onkeyup="ubahHargaBeli()">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="harga_biasa" id="harga_biasa_2" class="form-control form-control-sm" value="0">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="margin_resep" id="margin_resep_2" class="form-control form-control-sm" value="0" onkeyup="ubahHargaBeli()">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="harga_resep" id="harga_resep_2" class="form-control form-control-sm" value="0">
                    </div>
                </div>
                <!-- Stok Awal -->
                <!-- <div class="row">
                    <div class="col-md-12">
                        <hr>
                    </div>
                    <div class="col-md-12">
                        <small class="font-weight-bold">**Stok Awal</small>
                    </div>
                    <div class="col-md-3">
                        <small class="font-weight-bold">Jumlah</small>
                        <input type="number" name="" id="" class="form-control form-control-sm" min="0">
                    </div>
                    <div class="col-md-3">
                        <small class="font-weight-bold">Satuan</small>
                        <select name="" id="" class="form-control form-control-sm">
                        </select>
                    </div>
                    <div class="col-md-3">
                        <small class="font-weight-bold">Expired Date</small>
                        <input type="date" name="" id="" class="form-control form-control-sm">
                    </div>
                </div> -->
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
        ubahLevelSatuan();
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
        $("#ModalLabel").html('Tambah Data Produk')
        emptyField();
    });

    //Save Data
    $('#btnSave').on('click', function(event) {
        event.preventDefault();
        //Data Konversi
        var data_konversi = {};
        for(var i=1;i<=2;i++){
            data_konversi[i] = {
                'level' : i,
                'id' : $("#id_konversi_"+i).val(),
                'satuan_jual' : $("#satuan_jual_"+i).val(),
                'nilai_konversi' : $("#nilai_konversi_"+i).val(),
                'margin_biasa' : $("#margin_biasa_"+i).val(),
                'harga_biasa' : $("#harga_biasa_"+i).val(),
                'margin_resep' : $("#margin_resep_"+i).val(),
                'harga_resep' : $("#harga_resep_"+i).val(),
            };
        }
        //Ajax Processing
        $.ajax({
            url : "{{ url('/produk/store') }}",
            method : "POST",
            data : {
                'id_' : $("#id_").val(),
                'kode_produk' : $("#kode_produk").val(),
                'kategori' : $("#kategori").val(),
                'nama_produk' : $("#nama_produk").val(),
                'stok_minimal' : $("#stok_minimal").val(),
                'harga_beli' : $("#harga_beli").val(),
                'produsen' : $("#produsen").val(),
                'supplier' : $("#supplier").val(),
                'level_satuan' : $("#level_satuan").val(),
                'margin_pajak' : $("#margin_pajak").val(),
                'data_konversi' : data_konversi,
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
        $("#kode_produk").val("")
        $("#kategori").val("")
        $("#nama_produk").val("")
        $("#stok_minimal").val(0)
        $("#harga_beli").val(0)
        $("#produsen").val("")
        $("#supplier").val("")
        $("#level_satuan").val(1)
        $("#margin_pajak").val(1)

        ubahLevelSatuan()
        
        $("#id_konversi_1").val("")
        $("#satuan_jual_1").val("Dus")
        $("#nilai_konversi_1").val(1)
        $("#margin_biasa_1").val(0)
        $("#harga_biasa_1").val(0)
        $("#margin_resep_1").val(0)
        $("#harga_resep_1").val(0)

        $("#id_konversi_2").val("")
        $("#satuan_jual_2").val("Dus")
        $("#nilai_konversi_2").val(1)
        $("#margin_biasa_2").val(0)
        $("#harga_biasa_2").val(0)
        $("#margin_resep_2").val(0)
        $("#harga_resep_2").val(0)

    }

    //Ubah Harga Beli
    function ubahHargaBeli(){
        var harga_beli = parseInt($("#harga_beli").val());
        var level_satuan = $("#level_satuan").val();
        var margin_pajak = $("#margin_pajak").val();
        // alert(margin_pajak)
        for(var i=1;i<=level_satuan;i++){
            //Nilai Konversi
            var nilai_konversi = parseInt($("#nilai_konversi_"+i).val());
            var harga_dasar = harga_beli / nilai_konversi;
            
            //Harga Produk dengan Pajak 10%
            var harga_plus_pajak = 0;
            if(margin_pajak == 1){
                harga_plus_pajak = (harga_dasar * 10 / 100) 
            }
            //Harga Biasa
            var margin_biasa = parseInt($("#margin_biasa_"+i).val());          
            var harga_biasa = harga_dasar + (harga_dasar * margin_biasa / 100) + harga_plus_pajak;
            $("#harga_biasa_"+i).val(harga_biasa);

            //Harga Resep
            var margin_resep = parseInt($("#margin_resep_"+i).val());
            var harga_resep = harga_dasar + (harga_dasar * margin_resep / 100) + harga_plus_pajak;
            // if(margin_pajak == 1){harga_resep += harga_dasar + (harga_dasar * margin_pajak / 100);}
            $("#harga_resep_"+i).val(harga_resep);
        }
    }

    //Ubah Level Satuan
    function ubahLevelSatuan(){
        var value = $('#level_satuan').val();
        for(var i=1;i<=value;i++){
            $("#satuan_jual_"+i).removeAttr('readonly');
            $("#nilai_konversi_"+i).removeAttr('readonly');
            $("#margin_biasa_"+i).removeAttr('readonly');
            $("#harga_biasa_"+i).removeAttr('readonly');
            $("#margin_resep_"+i).removeAttr('readonly');
            $("#harga_resep_"+i).removeAttr('readonly');
        }
        for(var i=2;i>value;i--){
            $("#satuan_jual_"+i).attr('readonly','true');
            $("#nilai_konversi_"+i).attr('readonly','true');
            $("#margin_biasa_"+i).attr('readonly','true');
            $("#harga_biasa_"+i).attr('readonly','true');
            $("#margin_resep_"+i).attr('readonly','true');
            $("#harga_resep_"+i).attr('readonly','true');
        }

        $("#nilai_konversi_1").val(1);
        $("#nilai_konversi_1").attr('readonly','true');
    }

    //DataTable 
    function loadDataTable(){
        destroyDataTable();
        $("#table_view").DataTable({
            "responsive": true,
            "autoWidth": false,
            processing : true,
            serverSide : true,
            ajax : "{{ url('/produk/data') }}",
            columns: [
                {render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }  
                },
                {data : 'nama_kategori'},
                {data : 'id'},
                {data : 'nama_produk'},
                {"className" : "text-right", data : 'stok_minimal'},
                {render: function (data, type, row, meta) {
                        var status_pajak_produk = row.status_pajak_produk == "1" ? "Margin Pajak" : "Tanpa Pajak";
                        return status_pajak_produk;
                    }  
                },
                {data : 'nama_produsen'},
                {data : 'nama_supplier'},
                {"className" : "text-center",
                    render: function (data, type, row, meta) {
                        var action_button = "<button class='btn btn-sm btn-primary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Aksi </button>"+
                                "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>"+
                                    "<a class='dropdown-item' href='#' onclick='edit(\""+row.id+"\")'>Edit</a>"+
                                    // "<a class='dropdown-item' href='#' onclick='del(\""+row.id+"\")'>Delete</a>"+
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

    function edit(produkID){
        $("#modal_").modal('show');
        $("#ModalLabel").addClass("font-weight-bold")
        $("#ModalLabel").html('Edit Data Produk')
        $.ajax({
            type : "GET",
            url: "{{ url('produk')}}"+"/edit/"+produkID,
            success: function (ajaxData) {
                // console.log(ajaxData.produk_konversi_stok)
                $("#id_").val(ajaxData.produk.id)
                $("#kode_produk").val(ajaxData.produk.id)
                $("#kategori").val(ajaxData.produk.kategori_produk_id)
                $("#nama_produk").val(ajaxData.produk.nama_produk)
                $("#stok_minimal").val(ajaxData.produk.stok_minimal)
                $("#harga_beli").val(ajaxData.produk.harga_beli)
                $("#produsen").val(ajaxData.produk.produsen_id)
                $("#supplier").val(ajaxData.produk.supplier_id)
                $("#level_satuan").val(ajaxData.produk.level_satuan)
                $("#margin_pajak").val(ajaxData.produk.status_pajak_produk)

                ubahLevelSatuan();

                $("#id_konversi_1").val(ajaxData.produk_konversi_stok[0].id)
                $("#satuan_jual_1").val(ajaxData.produk_konversi_stok[0].satuan)
                $("#nilai_konversi_1").val(ajaxData.produk_konversi_stok[0].nilai_konversi)
                $("#margin_biasa_1").val(ajaxData.produk_konversi_stok[0].laba_harga_biasa)
                $("#harga_biasa_1").val(ajaxData.produk_konversi_stok[0].harga_biasa)
                $("#margin_resep_1").val(ajaxData.produk_konversi_stok[0].laba_harga_resep)
                $("#harga_resep_1").val(ajaxData.produk_konversi_stok[0].harga_resep)

                $("#id_konversi_2").val(ajaxData.produk_konversi_stok[1].id)
                $("#satuan_jual_2").val(ajaxData.produk_konversi_stok[1].satuan)
                $("#nilai_konversi_2").val(ajaxData.produk_konversi_stok[1].nilai_konversi)
                $("#margin_biasa_2").val(ajaxData.produk_konversi_stok[1].laba_harga_biasa)
                $("#harga_biasa_2").val(ajaxData.produk_konversi_stok[1].harga_biasa)
                $("#margin_resep_2").val(ajaxData.produk_konversi_stok[1].laba_harga_resep)
                $("#harga_resep_2").val(ajaxData.produk_konversi_stok[1].harga_resep)
            },
        });            
    }

    function del(produkID){
        if(confirm('Anda Yakin Menghapus Data?')){
            $.ajax({
                type : "POST",
                url: "{{ url('produk')}}"+'/delete/'+produkID,
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