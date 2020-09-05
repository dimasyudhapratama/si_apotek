@extends('master_template')

@section('konten')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Detail Laporan Koreksi Stok ({{ $data_master_koreksi_stok->id }}) - {{ date('d/m/Y H:i:s',strtotime($data_master_koreksi_stok->created_at)) }}</b></h5>
                        <div class="card-tools">
                            <a href="{{ url('/') }}">Home</a> / Detail Laporan Penjualan
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <small class="font-weight-bold">Keterangan Koreksi Stok</small>
                                <textarea name="keterangan" id="keterangan" class="form-control form-control-sm" readonly>{{ $data_master_koreksi_stok->keterangan }}</textarea>
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
                                            <td class="text-center font-weight-bold">Produk</td>
                                            <td class="text-center font-weight-bold">Qty Awal</td>
                                            <td class="text-center font-weight-bold">Qty Akhir</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1 @endphp
                                        @foreach($data_detail_koreksi_stok as $i)
                                        <tr>
                                            <td>{{ $no++ }}.</td>
                                            <td>{{ $i->produk_id }}</td>
                                            <td>{{ $i->nama_produk." (".$i->satuan.")" }}</td>
                                            <td class="text-right">{{ $i->qty_awal }}</td>
                                            <td class="text-right">{{ $i->qty_akhir }}</td>
                                        </tr>
                                        @endforeach
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
