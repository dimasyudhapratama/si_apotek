@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Laporan Komisi Dokter</b></h5>
                        <div class="card-tools">
                            <a href="{{ url('/') }}">Home</a> / Laporan Komisi Dokter
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <small class="font-weight-bold">Dokter</small>
                                <input type="text" name="dokter" id="dokter" class="form-control-plaintext" value="{{ $dokter->nama }}" disabled>
                            </div>
                            <div class="col-md-4">
                                <small class="font-weight-bold">Bulan-Tahun</small>
                                <input type="text" name="bulan_tahun" id="bulan_tahun" class="form-control-plaintext" value="{{ $month }} - {{ $year }}" disabled>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-sm mt-2">
                                    <thead>
                                        <tr>
                                            <td class="text-center font-weight-bold">No.</td>
                                            <td class="text-center font-weight-bold">Kode</td>
                                            <td class="text-center font-weight-bold">Tanggal</td>
                                            <td class="text-center font-weight-bold">Total Komisi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                        $no = 1;
                                        $grand_total = 0;                                        
                                        @endphp

                                        @foreach($penjualan as $i)
                                        <tr>
                                            <td>{{ $no++ }}.</td>
                                            <td>{{ $i->id }}</td>
                                            <td>{{ $i->created_at }}</td>
                                            <td class="text-right">Rp. {{ number_format($i->grand_total * 2 / 100,2,',','.') }}</td>
                                        </tr>
                                        @php $grand_total += $i->grand_total @endphp
                                        @endforeach
                                        <tr>
                                            <td class="text-center font-weight-bold" colspan="3">Grand Total</td>
                                            <td class="text-right">Rp. {{ number_format($grand_total * 2 / 100,2,',','.') }}</td>
                                        </tr>
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
