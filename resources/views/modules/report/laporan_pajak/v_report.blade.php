@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Laporan Pajak</b></h5>
                        <div class="card-tools">
                            <a href="{{ url('/') }}">Home</a> / Laporan Pajak
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <small class="font-weight-bold">Bulan</small>
                                <select name="month" id="month" class="form-control form-control-sm">
                                    @php $last_month=date('m', strtotime(date('Y-m')." -1 month")); @endphp
                                    @for($month=1;$month<=12;$month++)
                                        <option value="{{ $month }}" <?php if($last_month == $month){echo "Selected";} ?>>{{ $month }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <small class="font-weight-bold">Tahun</small>
                                <select name="year" id="year" class="form-control form-control-sm">
                                    @php $year_in_last_month =date('Y', strtotime(date('Y-m')." -1 month")); @endphp
                                    @for($year=date('Y');$year>=2020;$year--)
                                        <option value="{{ $year }}" <?php if($year_in_last_month == $year){echo "Selected";} ?>>{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <button type="button" class="btn btn-sm btn-primary" onclick="loadReport()">Proses</button>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p></p>
                                <table class="table table-striped table-bordered table-sm mt-2">
                                    <thead>
                                        <tr>
                                            <td class="text-center font-weight-bold">No.</td>
                                            <td class="text-center font-weight-bold">Dokter</td>
                                            <td class="text-center font-weight-bold">Komisi Bulanan</td>
                                            <td class="text-center font-weight-bold">Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody id="table_output">
                                    </tbody>
                                </table>
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
    $(function(){
        loadReport()
    });

    function loadReport(){
        

        $("#table_output").empty()
        $.ajax({
            type : "GET",
            url: "{{ url('laporan_pajak/proccess')}}",
            data : {
                'month' : $("#month :selected").val(),
                'year' : $("#year :selected").val()
            },
            success: function (ajaxData) {
                var data = JSON.parse(ajaxData);
                var no=1;
                var total_pendapatan_dokter = 0;
                
                for(i=0;i<data.length;i++){
                    $("#table_output").append(
                        "<tr>"+
                            "<td>"+ no +"</td>"+
                            "<td>"+ data[i]['nama'] +"</td>"+
                            "<td class='text-right'>Rp. "+ data[i]['pendapatan_dokter'] +"</td>"+
                            "<td class='text-center'><a></a></td>"+
                        "</tr>"
                    );

                    total_pendapatan_dokter += parseFloat(data[i]['pendapatan_dokter'])
                }

                $("#table_output").append(
                    "<tr>"+
                        "<td colspan='2' class='text-center font-weight-bold'>Total</td>"+
                        "<td class='text-right font-weight-bold'>Rp. "+ total_pendapatan_dokter +"</td>"+
                        "<td></td>"+
                    "</tr>"
                )
            },
        });       
    }
</script>
@endsection