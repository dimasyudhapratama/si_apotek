@extends('master_template')

@section('konten')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Tentang Sistem</b></h5>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / Tentang Sistem
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Sistem Informasi Apotek dibawah Lisensi EraIT Software <br>&copy; 2020 - {{ date('Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
