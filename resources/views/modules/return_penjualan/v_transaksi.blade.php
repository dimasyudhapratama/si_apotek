@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h6 class="card-title m-0"><b>Return Penjualan</b></h6>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / Return Penjualan
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
                                    <small class="font-weight-bold">Kode Resep</small>
                                    <input type="text" name="kode_resep" class="form-control form-control-sm" id="kode_resep">
                                </div> 
                                <div class="col-md-2">
                                    <small class="font-weight-bold">Tipe Penjualan</small>
                                    <input type="text" name="tipe_penjualan" class="form-control form-control-sm" id="tipe_penjualan" readonly>
                                </div> 
                                <div class="col-md-2">
                                    <small class="font-weight-bold">Dokter</small>
                                    <input type="text" name="dokter" class="form-control form-control-sm" id="dokter" readonly>
                                </div> 
                                <div class="col-md-2">
                                    <small class="font-weight-bold">Customer</small>
                                    <input type="text" name="customer" class="form-control form-control-sm" id="customer" readonly>
                                    
                                </div> 
                                <div class="col-md-2">
                                    <small class="font-weight-bold">Cara Pembayaran</small>
                                    <input type="text" name="cara_pembayaran" class="form-control form-control-sm" id="cara_pembayaran" readonly>
                                </div> 
                                <div class="col-md-2">
                                    <small class="font-weight-bold">Jatuh Tempo</small>
                                    <input type="date" name="jatuh_tempo" id="jatuh_tempo" class="form-control form-control-sm" readonly>
                                </div> 
                            </div>
                            <div class="row">
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
                                    <small class="font-weight-bold">Expired Date</small>
                                </div>
                                <div class="col-md-2">
                                    <small class="font-weight-bold">Satuan</small>
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
                        <hr>
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-2">
                                        <small class="font-weight-bold">Total</small>
                                        <input type="number" name="total" id="total" class="form-control form-control-sm required" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <small class="font-weight-bold">Diskon</small>
                                        <input type="number" name="diskon_idr" id="diskon_idr" class="form-control form-control-sm required" value="0" onkeyup="countGrandTotal()">
                                    </div>
                                    <div class="col-md-2">
                                        <small class="font-weight-bold">Grand Total</small>
                                        <input type="number" name="grand_total" id="grand_total" class="form-control form-control-sm required" readonly>
                                    </div>
                                    <div class="col-md-2">
                                        <small class="font-weight-bold">Bayar</small>
                                        <input type="number" name="bayar_idr" id="bayar_idr" class="form-control form-control-sm required" value="0" onkeyup="countUangKembali()">
                                    </div>
                                    <div class="col-md-2">
                                        <small class="font-weight-bold">Kembalian Pembayaran</small>
                                        <input type="number" name="sisa_idr" id="sisa_idr" class="form-control form-control-sm required" readonly>
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
    //CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //Initialization - Loaded First
    //Beberapa Function Yang di Load di Awal
    var row_id = 0;
    $(function () {
        $("#alert_").hide()
    });

    //Ketika Tekan Enter di Kode Resep
    $('#kode_resep').on('keypress', function(event) {
        //Menangkap Input Keyboard
        //Jika Menekan Enter Maka diproses Lebih Lanjut
        if(event.which == 13){
            $("body").loading('start')

            var kode_resep = $('#kode_resep').val()
            cariDataPenjualan(kode_resep)
            
            $("body").loading('stop')
        }
    });

    //Save Only - Without Print
    $("#btn-save").on('click',function(event){
        if(checkRequired()){
            save(1);
        }
    });

    //Save With Print
    $("#btn-save-print").on('click',function(event){
        if(checkRequired()){
            save(2);
        }
    });

    //New / Reload
    $("#btn-reload").on('click',function(event){
        location.reload();
    }); 

    ////////////////////Function//////////////////////

    //Start Function Detail Product

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

    //Fungsi Untuk Mencari Data Penjualan
    function cariDataPenjualan(kode_resep){
        $.ajax({
            url : "{{ url('/return_penjualan/getDataPenjualanByPenjualanId')}}"+"/"+kode_resep,
            method : "GET",
            success : function(ajaxData){
                console.log(ajaxData['master_penjualan'])
                // Jika Proses pengambilan data dari backend berhasil                
                if(ajaxData['status'] == "success"){
                    //Set Data dari Ajax Ke Form
                    $("#tipe_penjualan").val(ajaxData['master_penjualan']['tipe_penjualan'])
                    $("#dokter").val(ajaxData['master_penjualan']['nama_dokter'])
                    $("#customer").val(ajaxData['master_penjualan']['nama_customer'])
                    $("#cara_pembayaran").val(ajaxData['master_penjualan']['cara_pembayaran'])
                    $("#jatuh_tempo").val(ajaxData['master_penjualan']['jatuh_tempo'])
                    
                    ajaxData['detail_penjualan'].forEach(function(record){
                        addRow(record)
                    });
                    
                }else{
                    alert('Data Tidak Ditemukan');
                }
            }
        });
    }

    //Fungsi Untuk Menambah Row Baru
    function addRow(record){
        var data =  "<div class='row mt-1' id='row_"+row_id+"'>"+
                        "<div class='col-md-2'>"+
                            "<input type='text' name='kode_produk[]' id='kode_produk_"+row_id+"' class='form-control form-control-sm required' value='"+record['produk_id']+"' readonly>"+
                        "</div>"+
                        "<div class='col-md-2'>"+
                            "<input type='text' name='nama_produk[]' id='nama_produk_"+row_id+"' class='form-control form-control-sm required' value='"+record['nama_produk']+"' readonly>"+
                        "</div>"+
                        "<div class='col-md-2'>"+
                            "<input type='text' name='exp_date[]' id='exp_date_"+row_id+"' class='form-control form-control-sm required' value='"+record['produk_stok_detail_exp_date']+"' readonly>"+
                        "</div>"+
                        "<div class='col-md-2'>"+
                            "<input type='hidden' name='satuan[]' id='satuan_"+row_id+"' class='form-control form-control-sm required' value='"+record['produk_konversi_stok_id']+"' readonly>"+
                            "<input type='text' name='deskripsi_satuan_[]' id='deskripsi_satuan_"+row_id+"' class='form-control form-control-sm required' value='"+record['satuan']+"' readonly>"+
                        "</div>"+
                        "<div class='col-md-1'>"+
                            "<input type='number' name='harga[]' id='harga_"+row_id+"' class='form-control form-control-sm required' value='"+record['harga']+"' onkeyup='countSubTotal("+row_id+")'>"+
                        "</div>"+
                        "<div class='col-md-1'>"+
                            "<input type='number' name='qty[]' id='qty_"+row_id+"' class='form-control form-control-sm required' value='"+record['qty']+"' max='"+record['qty']+"' onkeyup='countSubTotal("+row_id+")'>"+
                        "</div>"+
                        "<div class='col-md-1'>"+
                            "<input type='number' name='sub_total[]' id='sub_total_"+row_id+"' value='"+record['subtotal']+"' class='form-control form-control-sm required'>"+
                        "</div>"+
                        "<div class='col-md-1'>"+
                            "<button type='button' class='btn btn-sm btn-danger' onclick='removeRow("+row_id+")'><i class='fa fa-trash'></i></button>"+
                        "</div>"+
                    "</div>";
        $("#div_appended_target").append(data);
        countSubTotal();
        row_id += 1;
    }

    //Fungsi Untuk Mengosongkan Field pada Row
    function emptyRow(row_id){
        $("#nama_produk_"+row_id).val("")
        $("#exp_date_"+row_id).val("")
        $("#satuan_"+row_id).empty()
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

    //Fungsi Untuk Mengubah Harga penjualan
    function ubahHargaPenjualan(){
        $('input[name="harga[]"]').map(function(){ 
            var input_harga_row = $(this).attr('id')
            var split_row = input_harga_row.split('_')
            var row_id = split_row[1]

            getHargaProdukById(row_id)

        })
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

    //Fungsi Untuk Menghitung Total
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

        var format_rupiah = (grand_total/1000).toFixed(3);
        $("#grand_total_idr").text("Rp. "+format_rupiah);
    }

    //Fungsi Untuk Menghitung Uang Kembalian
    function countUangKembali(){
        var grand_total = parseInt($("#grand_total").val());
        var bayar = parseInt($("#bayar_idr").val());
        
        var sisa = bayar - grand_total;
        $("#sisa_idr").val(sisa);
    }

    //Fungsi Untuk Menyimpan Data ke Dalam Database
    function save(tipe){
        //Tipe 1 Untuk Tanpa Print
        //Tipe 2 Untuk Dengan Print
        $.ajax({
            url : "{{ url('/return_penjualan/store')}}",
            method : "POST",
            data : {
                penjualan_id : $("#kode_resep").val(),
                //
                kode_produk : $('input[name="kode_produk[]"]').map(function(){ return this.value; }).get() ,
                exp_date : $('input[name="exp_date[]"]').map(function(){ return this.value; }).get() ,
                satuan : $('input[name="satuan[]"]').map(function(){ return this.value; }).get() , 
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
                }else{
                    $("#alert_messages_").text('Transaksi Gagal');
                }
                $("#alert_").show();
                //Jika Butuh Print Maka Redirect
                if(tipe == 2){
                    window.open("{{ url('/return_penjualan/cetak')}}"+'/'+ajaxData['invoice_number'], '_blank');
                }
                //Restart Transaction
                restartTransaction()
            }
        });
    }

    //Fungsi Untuk Merestart Transaksi
    function restartTransaction(){
        //Restart Data Transaksi Jadi Nilai Default
        $("#kode_resep").val("")
        $("#tipe_penjualan").val("")
        $("#dokter").val("")
        $("#customer").val("")
        $("#cara_pembayaran").val("")
        $("#jatuh_tempo").val("")        

        //Delete Detail Data Transaksi
        //Get Row ID dengan cara looping subtotal dan mengambil ID
        $('input[name="sub_total[]"]').map(function(){ 
            var input_subtotal_row = $(this).attr('id')
            var split_row = input_subtotal_row.split('_')
            var row_id = split_row[2]
            console.log(row_id)

            removeRow(row_id)
        })

        $("#total").val(0)
        $("#diskon_idr").val(0)
        $("#grand_total").val(0)
        $("#bayar_idr").val(0)
        $("#sisa_idr").val(0)
    }
</script>
@endsection