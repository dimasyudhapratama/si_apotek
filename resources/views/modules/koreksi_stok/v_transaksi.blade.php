@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h6 class="card-title m-0"><b>Koreksi Stok</b></h6>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / Koreksi Stok
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="alert_" class="alert alert-info alert-dismissible fade show" role="alert">
                            <b id="alert_messages_">&nbsp;</b>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        <div id="div_appended_target">
                            <div class="row">
                                <div class="col-md-2">
                                    <small class="font-weight-bold">Kode Produk</small>
                                </div>
                                <div class="col-md-2">
                                    <small class="font-weight-bold">Nama Produk</small>
                                </div>
                                <div class="col-md-2">
                                    <small class="font-weight-bold">Expired</small>
                                </div>
                                <div class="col-md-2">
                                    <small class="font-weight-bold">Satuan - Stok</small>
                                </div>
                                <div class="col-md-2">
                                    <small class="font-weight-bold">Koreksi Stok</small>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-3">
                                <button class="btn btn-sm btn-success" id="add-row"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-12">
                                        <small class="font-weight-bold">Keterangan</small>
                                        <textarea name="keterangan" id="keterangan" class="form-control form-control-sm" placeholder="Isi Dengan Alasan Mengapa melakukan Koreksi Stok" required></textarea>
                                    </div>
                                </div>
                                <div class="row mt-2">                                    
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-sm btn-primary" id="btn-save"><i class="fa fa-save"></i> Simpan</button>
                                        <button type="button" class="btn btn-sm btn-default" id="btn-reload"><i class="fa fa-file"></i> Baru</button>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="modal fade" id="modal_select_product" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel"><b>Pilih Produk</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="row_number_detail_product" id="row_number_detail_product" value="">
                <table class="table table-sm table-striped table-bordered" id="table_product">
                    <thead>
                        <tr>
                            <td class="font-weight-bold text-center">Kode</td>
                            <td class="font-weight-bold text-center">Produk</td>
                            <td class="font-weight-bold text-center">Stok 1</td>
                            <td class="font-weight-bold text-center">Stok 2</td>
                            <td class="font-weight-bold text-center">Stok 3</td>
                            <td class="font-weight-bold text-center">Stok 4</td>
                            <td class="font-weight-bold text-center">Aksi</td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('konten_js')
<script>
    //CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Initialization - Loaded First
    //Beberapa Function Yang di Load di Awal
    var row_idX = 0;
    $(function () {
        $("#alert_").hide()
        addRow(row_idX)
    });    


    //Ketika Klik Tombol Add Row
    $('#add-row').on('click', function(event) {
        addRow(row_idX);
    });

    //Save Only - Without Print
    $("#btn-save").on('click',function(event){
        if(checkRequired()){
            save(1);
        }
    });

    //New / Reload
    $("#btn-reload").on('click',function(event){
        location.reload();
    }); 

    ////////////////////Function//////////////////////
    //Master Tramsaksi

    //Start Function Detail Product Yang akan Dijual

    //Fungsi Untuk Menambah Row Baru
    function addRow(row_id){
        var data =  "<div class='row mt-1' id='row_"+row_id+"'>"+
                        "<div class='col-md-2'>"+
                            "<div class='row'>"+
                                "<div class='col-md-2'>"+
                                    "<button type='button' class='btn btn-sm btn-warning' onclick='openModalsearchProduct("+row_id+")'><i class='fa fa-search'></i></button>"+
                                "</div>"+
                                "<div class='col-md-10'>"+
                                    "<input type='text' name='kode_produk[]' id='kode_produk_"+row_id+"' class='form-control form-control-sm required' onkeypress='getProdukById("+row_id+",event)'>"+
                                "</div>"+    
                            "</div>"+
                        "</div>"+
                        "<div class='col-md-2'>"+
                            "<input type='text' name='nama_produk[]' id='nama_produk_"+row_id+"' class='form-control form-control-sm required' readonly>"+
                        "</div>"+
                        "<div class='col-md-2'>"+
                            "<select name='exp_date[]' id='exp_date_"+row_id+"' class='form-control form-control-sm required' onchange='getSatuanByProdukExpDate("+row_id+")'></select>"+
                        "</div>"+
                        "<div class='col-md-2'>"+
                            "<select name='satuan[]' id='satuan_"+row_id+"' class='form-control form-control-sm required'></select>"+
                        "</div>"+
                        "<div class='col-md-1'>"+
                            "<input type='number' name='qty[]' id='qty_"+row_id+"' class='form-control form-control-sm required' value='1'>"+
                        "</div>"+
                        "<div class='col-md-1'>"+
                            "<button type='button' class='btn btn-sm btn-danger' onclick='removeRow("+row_id+")'><i class='fa fa-trash'></i></button>"+
                        "</div>"+
                    "</div>";
        $("#div_appended_target").append(data);
        row_idX += 1;
    }

    //Fungsi Untuk Mengosongkan Field pada Row
    function emptyRow(row_id){
        $("#nama_produk_"+row_id).val("")
        $("#exp_date_"+row_id).val("")
        $("#satuan_"+row_id).empty()
    }

    //Fungsi untuk Menghapus Row
    function removeRow(row_id){
        $("#row_"+row_id).remove();
    }

    //Function yang digunakan Untuk Menecek dan Memastikan data terisi
    function checkRequired(){
        var status = true
        $(".required").each(function(){
            $(this).removeClass("is-invalid")
            if($(this).val() == "" || $(this).val() == null){
                $(this).addClass("is-invalid")
                status = false
            }
        });
        return status;
    }
    
    
    //Membuka Modal Pencarian Product
    function openModalsearchProduct(row_id){
        $("#row_number_detail_product").val(row_id)
        loadDataTableProduct()
        $("#modal_select_product").modal('show')
    }

    //Menampilkan DataTable Pada Modal Pencarian Product
    function loadDataTableProduct(){
        destroyDataTableProduct();
        $("#table_product").DataTable({
            "responsive": true,
            "autoWidth": false,
            processing : true,
            serverSide : true,
            ajax : "{{ url('/produk/data_processed') }}",
            columns: [
                {data : 'id'},
                {data : 'nama_produk'},
                {"className" : "text-right", data : 'stok_aktual'},
                { "className" : "text-center",
                    render: function (data, type, row, meta) {
                        // varibel row.id mewakili ID Produk
                        var action_button = "<button type='button' class='btn btn-sm btn-primary' onclick='selectProductFromModal(\""+row.id+"\")'>Pilih</button>";
                        return action_button;
                    }  
                },
            ],
        });
    }

    //Destroy Datatable - Digunakan Sebagai bug Fixing
    function destroyDataTableProduct(){
        if ($.fn.DataTable.isDataTable('#table_product')) {
            $('#table_product').DataTable().destroy();
        }
    }

    //Memilih Product Pada Datatable di Modal Product
    function selectProductFromModal(produk_id){
        var row_id = $("#row_number_detail_product").val()
        $("#kode_produk_"+row_id).val(produk_id)
        getProdukById(row_id, "","modal")
        $("#modal_select_product").modal('hide')

    }
    
    //Menampilkan Produk Berdasar Row ID
    function getProdukById(row_id, event, input_source="textbox"){
        //Input Source Ada 2, yaitu dari textbox dan modal
        if(input_source == "textbox"){ //Input Source dari TextBox
            //Mengambil Keyboard Code
            keyCode = event.which            

            //Jika Keyboard Code Adalah Enter Maka Diproses
            if(keyCode == 13){
                $("body").loading("start")
                emptyRow(row_id)
                getProductDetailById(row_id);
                getNonExpiredDataProduk(row_id);
                $("body").loading("stop")     
            }

        }else if(input_source == "modal"){ //Input Source dari Modal
            $("body").loading("start")
            emptyRow(row_id)
            getProductDetailById(row_id);
            getNonExpiredDataProduk(row_id);
            $("body").loading("stop")     
        }   
    }

    //Fungsi Untuk Product Detail Berdasarkan Kode Produk
    function getProductDetailById(row_id){
        var id = $("#kode_produk_"+row_id).val();
        //Get Nama Produk
        if(id != ""){
            $.ajax({
                url : "{{ url('/koreksi_stok/getDetailProduk')}}"+'/'+id,
                method : "GET",
                success : function(ajaxData){
                    if(ajaxData.length > 0){
                        var nama_produk = ajaxData[0]['nama_produk'];
                        $("#nama_produk_"+row_id).val(nama_produk);  
                    }
                }
            });
        }
    }

    //Fungsi Untuk Mendaptkan Data Produk Yang Non Expired
    function getNonExpiredDataProduk(row_id){
        //Empty Option Data
        $('#exp_date_'+row_id).find('option').remove().end();

        var id = $("#kode_produk_"+row_id).val();
        //Get Non Expired Data Produk
        if(id != ""){
            $.ajax({
                url : "{{ url('/koreksi_stok/getNonExpiredDataProduk')}}"+'/'+id,
                method : "GET",
                success : function(ajaxData){
                    if(ajaxData.length > 0){
                        console.log(ajaxData);
                        for(var i=0;i<ajaxData.length;i++){
                            var value = ajaxData[i]['exp_date']
                            var o = new Option(value, value);
                            $("#exp_date_"+row_id).append(o);
                        }
                    }
                    getSatuanByProdukExpDate(row_id);
                }
            });
        }
    }

    //Fungsi Untuk Menampilkan Satuan Yang Tersisa Berdasarkan Exp Date
    function getSatuanByProdukExpDate(row_id){
        //Empty Option Data
        $('#satuan_'+row_id).find('option').remove().end();

        var tipe_penjualan = $("#tipe_penjualan").val();
        var id = $("#kode_produk_"+row_id).val();
        var exp_date = $("#exp_date_"+row_id).find(":selected").val();
        
        // Get Satuan Produk
        if(id != ""){
            $.ajax({
                url : "{{ url('/koreksi_stok/getSatuanProduk')}}",
                method : "POST",
                data : {id : id, exp_date : exp_date, tipe_penjualan : tipe_penjualan},
                success : function(ajaxData){
                    if(ajaxData.length > 0){
                        for(var i=0;i<ajaxData.length;i++){
                            var value = ajaxData[i]['id']
                            var text = ajaxData[i]['satuan']+" - "+ajaxData[i]['jumlah'];
                            var o = new Option(text, value);
                            $("#satuan_"+row_id).append(o);
                        }
                    }
                }
            });
        }
    }

    //Fungsi Untuk Menyimpan Data ke Dalam Database
    function save(tipe){
        //Tipe 1 Untuk Tanpa Print
        //Tipe 2 Untuk Dengan Print
        $.ajax({
            url : "{{ url('/koreksi_stok/store')}}",
            method : "POST",
            data : {
                keterangan : $("#keterangan").val(),
                //
                kode_produk : $('input[name="kode_produk[]"]').map(function(){ return this.value; }).get() ,
                exp_date : $('select[name="exp_date[]"]').map(function(){ return this.value; }).get() ,
                satuan : $('select[name="satuan[]"]').map(function(){ return this.value; }).get() , 
                qty : $('input[name="qty[]"]').map(function(){ return this.value; }).get() ,
                
            },
            success : function(ajaxData){
                //Modifikasi Alert                
                if(ajaxData['status'] == "success"){
                    $("#alert_messages_").text('Transaksi Berhasil');

                }else{
                    $("#alert_messages_").text('Transaksi Gagal');
                }

                $("#alert_").show();
                
                //Restart Transaction
                restartTransaction()
            }
        });
    }

    //Fungsi Untuk Merestart Transaksi
    function restartTransaction(){
        //Restart Data Transaksi Jadi Nilai Default
        $("#keterangan").val("")        

        //Delete Detail Data Transaksi
        //Get Row ID dengan cara looping subtotal dan mengambil ID
        $('input[name="kode_produk[]"]').map(function(){ 
            var input_kode_produk_row = $(this).attr('id')
            var split_row = input_kode_produk_row.split('_')
            var row_id = split_row[2]

            removeRow(row_id)
        })


        //Add Row Baru
        addRow(0)
    }
</script>
@endsection