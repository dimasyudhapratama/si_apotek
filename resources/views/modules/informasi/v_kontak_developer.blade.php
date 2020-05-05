@extends('master_template')

@section('konten')
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Kontak Developer</b></h5>
                        <div class="float-right">
                            <a href="{{ url('/') }}">Home</a> / Kontak Developer
                        </div>
                    </div>
                    <div class="card-body">
                        <p>Jika terjadi masalah terkait Sistem Informasi Apotek, bisa menghubungi :</p>
                        <ol>
                            <li>Dimas Yudha Pratama - 082321190490 (WA/Telepon)</li>
                            <li>David Bristi - 082330428412 (WA/Telepon)</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
