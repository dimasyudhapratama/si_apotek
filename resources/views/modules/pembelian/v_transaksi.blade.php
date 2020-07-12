@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Pembelian - Kulak</b></h5>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / Pembelian - Kulak
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form-transaksi" action="" method="post">
                            <div id="alert_" class="alert alert-info alert-dismissible fade show" role="alert">
                                <b id="alert_messages_">&nbsp;</b>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div id="div_appended_target">
                                <div class="row">                                    
                                    <div class="col-md-3">
                                        <small class="font-weight-bold">Supplier</small>
                                        <select name="supplier" id="supplier" class="form-control form-control-sm">
                                            <option value="">--Pilih--</option>
                                            @foreach($supplier as $i)
                                            <option value="{{ $i->id }}">{{ $i->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div> 
                                    <div class="col-md-3">
                                        <small class="font-weight-bold">Cara Pembayaran</small>
                                        <select name="cara_pembayaran" id="cara_pembayaran" class="form-control form-control-sm required" onchange="checkCaraPembayaran()">
                                            <option value="Cash">Cash</option>
                                            <option value="Kredit">Kredit</option>
                                        </select>
                                    </div> 
                                    <div class="col-md-3">
                                        <small class="font-weight-bold">Jatuh Tempo</small>
                                        <input type="date" name="jatuh_tempo" id="jatuh_tempo" class="form-control form-control-sm">
                                    </div> 
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
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
                                        <small class="font-weight-bold">Satuan-Stok</small>
                                    </div>
                                    <div class="col-md-1">
                                        <small class="font-weight-bold">Harga</small>
                                    </div>
                                    <div class="col-md-1">
                                        <small class="font-weight-bold">Qty</small>
                                    </div>
                                    <div class="col-md-1">
                                        <small class="font-weight-bold">Sub Total</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-sm btn-success" id="add-row"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <small class="font-weight-bold">Total</small>
                                            <input type="number" name="total" id="total" class="form-control form-control-sm required" value="0" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <small class="font-weight-bold">Diskon</small>
                                            <input type="number" name="diskon_idr" id="diskon_idr" class="form-control form-control-sm required" value="0" onkeyup="countGrandTotal()">
                                        </div>
                                        <div class="col-md-2">
                                            <small class="font-weight-bold">Grand Total</small>
                                            <input type="number" name="grand_total" id="grand_total" class="form-control form-control-sm required" value="0" readonly>
                                        </div>
                                        <div class="col-md-2">
                                            <small class="font-weight-bold">Bayar</small>
                                            <input type="number" name="bayar_idr" id="bayar_idr" class="form-control form-control-sm required" value="0" onkeyup="countUangKembali()">
                                        </div>
                                        <div class="col-md-2">
                                            <small class="font-weight-bold">Kembalian Pembayaran</small>
                                            <input type="number" name="sisa_idr" id="sisa_idr" class="form-control form-control-sm required" value="0" readonly>
                                        </div>
                                    </div>   
                                    <div class="row mt-2">
                                        <div class="col-md-4">
                                            <button type="button" class="btn btn-sm btn-primary" id="btn-save"><i class="fa fa-save"></i> Simpan</button>
                                            <button type="button" class="btn btn-sm btn-info" id="btn-save-print"><i class="fa fa-print"></i> Simpan & Cetak</button>
                                            <button type="button" class="btn btn-sm btn-default" id="btn-reload"><i class="fa fa-file"></i> Baru</button>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </form>
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
        $("#alert_").hide();
        checkCaraPembayaran();
        addRow(row_idX);
        
    });

    $('#add-row').on('click', function(event) {
        addRow(row_idX);
    });

    //Save Only - Without Print
    $("#btn-save").on('click',function(event){
        event.preventDefault();        
        if(checkRequired()){
            save(1);
        }
    });

    //Save With Print
    $("#btn-save-print").on('click',function(event){
        event.preventDefault();
        if(checkRequired()){
            save(2);
        }
    });

    //New / Reload
    $("#btn-reload").on('click',function(event){
        location.reload();
    }); 

    ////////////////////Function//////////////////////
    //Master Transaksi

    //Mengecek Cara Pembayaran - Cash atau Kredit
    function checkCaraPembayaran(){
        if($("#cara_pembayaran").find(":selected").val() == "Cash"){
            $("#jatuh_tempo").attr('readonly','true');
            $("#jatuh_tempo").removeClass('required');
        }else if($("#cara_pembayaran").find(":selected").val() == "Kredit"){
            $("#jatuh_tempo").removeAttr('readonly');
            $("#jatuh_tempo").addClass('required');
        }
    }

    //End Master Transaksi

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
                            "<input type='date' name='exp_date[]' id='exp_date_"+row_id+"' class='form-control form-control-sm required'>"+
                        "</div>"+
                        "<div class='col-md-2'>"+
                            "<select name='satuan[]' id='satuan_"+row_id+"' class='form-control form-control-sm required-combobox' onchange='getHargaProdukById("+row_id+")'></select>"+
                        "</div>"+
                        "<div class='col-md-1'>"+
                            "<input type='hidden' name='harga_temp[]' id='harga_temp_"+row_id+"' class='form-control form-control-sm'>"+
                            "<input type='number' name='harga[]' id='harga_"+row_id+"' class='form-control form-control-sm required' onkeyup='countSubTotal("+row_id+")'>"+
                        "</div>"+
                        "<div class='col-md-1'>"+
                            "<input type='number' name='qty[]' id='qty_"+row_id+"' class='form-control form-control-sm required' value='1' onkeyup='countSubTotal("+row_id+")'>"+
                        "</div>"+
                        "<div class='col-md-1'>"+
                            "<input type='number' name='sub_total[]' id='sub_total_"+row_id+"' class='form-control form-control-sm required'>"+
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
        $("#harga_temp_"+row_id).val("")
        $("#harga_"+row_id).val("")
        $("#sub_total_"+row_id).val("")
    }

    //Fungsi untuk Menghapus Row
    function removeRow(row_id){
        $("#row_"+row_id).remove();
        countTotal();
        countGrandTotal();
        countUangKembali();
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
                {data : 'stok_minimal'},
                {data : 'stok_minimal'},
                {data : 'stok_minimal'},
                {data : 'stok_minimal'},
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
        $('#table_product tbody').empty();
    }

    //Memilih Product Pada Datatable di Modal Product
    function selectProductFromModal(produk_id){
        var row_id = $("#row_number_detail_product").val()
        $("#kode_produk_"+row_id).val(produk_id)
        getProdukById(row_id,"","modal")
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
                getSatuanProdukById(row_id);
                $("body").loading("stop")     
            }

        }else if(input_source == "modal"){ //Input Source dari Modal
            $("body").loading("start")
            emptyRow(row_id)
            getProductDetailById(row_id);
            getSatuanProdukById(row_id);
            $("body").loading("stop")     
        }   
    }

    //Fungsi Untuk Product Detail Berdasarkan Kode Produk
    function getProductDetailById(row_id){
        var id = $("#kode_produk_"+row_id).val();
        //Get Nama Produk
        if(id != ""){
            $.ajax({
                url : "{{ url('/pembelian/getDetailProduk')}}"+'/'+id,
                method : "GET",
                success : function(ajaxData){
                    if(ajaxData.length > 0){
                        var nama_produk = ajaxData[0]['nama_produk'];
                        var harga_temp = ajaxData[0]['harga_beli'];

                        $("#nama_produk_"+row_id).val(nama_produk);                    
                        $("#harga_temp_"+row_id).val(harga_temp);

                    }
                }
            });
        }
    }

    //Fungsi Untuk Menampilkan Satuan Produk
    function getSatuanProdukById(row_id){
        var id = $("#kode_produk_"+row_id).val();
        //Get Satuan Produk
        if(id != ""){
            $.ajax({
                url : "{{ url('/pembelian/getSatuanProduk')}}"+'/'+id,
                method : "GET",
                success : function(ajaxData){
                    if(ajaxData.length > 0){
                        for(var i=0;i<ajaxData.length;i++){
                            var value = ajaxData[i]['id']
                            var text = ajaxData[i]['satuan'];
                            var o = new Option(text, value);
                            $("#satuan_"+row_id).append(o);
                        }
                        //Ubah Harga
                        getHargaProdukById(row_id);
                    }
                }
            });
        }
    }

    //Menampilkan Harga Produk
    function getHargaProdukById(row_id){
        //Satuan
        var id = $("#satuan_"+row_id).find(":selected").val();     
        
        //Get Harga Per Satuan
        $.ajax({
            url : "{{ url('/pembelian/getKonversiSatuanProduk')}}"+'/'+id,
            method : "GET",
            success : function(ajaxData){
                if(ajaxData.length > 0){
                    //Harga Beli (Utama)
                    var harga_beli = $("#harga_temp_"+row_id).val();
                    //Nilai Konversi Per Satuan
                    var nilai_konversi = ajaxData[0]['nilai_konversi'];
                    //Operasi Pembagian   
                    var harga_per_satuan = harga_beli / nilai_konversi;
                    $("#harga_"+row_id).val(harga_per_satuan); 

                    countSubTotal(row_id);
                }
            }
        });
    }

    //Fungsi Untuk Menghitung Subtotal Per Row
    function countSubTotal(row_id){
        var harga = $("#harga_"+row_id).val();
        var qty = $("#qty_"+row_id).val();

        var subtotal = harga * qty;
        $("#sub_total_"+row_id).val(subtotal);

        countTotal();
        countGrandTotal();
        countUangKembali();
    }

    //Fungsi Untuk Menghitung Total Pembelian
    function countTotal(){
        var total = 0;
        //Count Total
        $('input[name="sub_total[]"]').map(function(){ 
            total += parseInt(this.value);
        })
        //Show to TextBox
        $("#total").val(total);
    }

    //Fungsi Untuk Menghitung Grand Total
    function countGrandTotal(){
        var total = parseInt($("#total").val());
        var diskon = parseInt($("#diskon_idr").val());
        
        var grand_total = total - diskon;
        $("#grand_total").val(grand_total);
    }

    //Fungsi Untuk Menghitung Uang Kembalian 
    function countUangKembali(){
        var grand_total = parseInt($("#grand_total").val());
        var bayar = parseInt($("#bayar_idr").val());
        
        var sisa = bayar - grand_total;
        $("#sisa_idr").val(sisa);
    }

    //Fungsi Untuk Menyimpan Data Ke Dalam Database
    function save(tipe){
        //Tipe 1 Untuk Tanpa Print
        //Tipe 2 Untuk Dengan Print
        $.ajax({
            url : "{{ url('/pembelian/store')}}",
            method : "POST",
            data : {
                supplier : $("#supplier").find(":selected").val(),
                cara_pembayaran : $("#cara_pembayaran").find(":selected").val(),
                jatuh_tempo : $("#jatuh_tempo").val(),
                //
                kode_produk : $('input[name="kode_produk[]"]').map(function(){ return this.value; }).get() ,
                exp_date : $('input[name="exp_date[]"]').map(function(){ return this.value; }).get() ,
                satuan : $('select[name="satuan[]"]').map(function(){ return this.value; }).get() , 
                harga : $('input[name="harga[]"]').map(function(){ return this.value; }).get() ,
                qty : $('input[name="qty[]"]').map(function(){ return this.value; }).get() ,
                subtotal : $('input[name="sub_total[]"]').map(function(){ return this.value; }).get() ,
                //
                total : $("#total").val(),
                diskon : $("#diskon_idr").val(),
                grand_total : $("#grand_total").val(),
                terbayar : $("#bayar_idr").val()
            },
            success : function(ajaxData){
                //Modifikasi Alert                
                if(ajaxData['status'] == "success"){
                    $("#alert_messages_").text('Transaksi Berhasil');

                    //Jika Butuh Print Maka Redirect
                    if(tipe == 2){
                        window.open("{{ url('/pembelian/struka4')}}"+'/'+ajaxData['invoice_number'], '_blank');
                    }

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
        $("#supplier").prop('selectedIndex', 0)
        $("#cara_pembayaran").prop('selectedIndex', 0)
        $("#jatuh_tempo").val("")        

        //Delete Detail Data Transaksi
        //Get Row ID dengan cara looping subtotal dan mengambil ID
        $('input[name="sub_total[]"]').map(function(){ 
            var input_subtotal_row = $(this).attr('id')
            var split_row = input_subtotal_row.split('_')
            var row_id = split_row[2]

            removeRow(row_id)
        })

        $("#total").val(0)
        $("#diskon_idr").val(0)
        $("#grand_total").val(0)
        $("#bayar_idr").val(0)
        $("#sisa_idr").val(0)
        //Add Row Baru
        addRow(0)
    }
</script>
@endsection