<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <title>SIM Apotek</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    .form-control-plaintext,th,td{
      font-size : 0.9rem;
    }
  </style>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar fixed-top navbar-expand-md navbar-light navbar-white m">
    <div class="container">
      <a href="{{ url('/') }}" class="navbar-brand">
        <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">SIM Apotek</span>
      </a>
      
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="{{ url('/')}}" class="nav-link">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Transaksi</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ url('/penjualan') }}" class="dropdown-item">Penjualan</a></li>
              <li><a href="{{ url('/pembelian') }}" class="dropdown-item">Pembelian</a></li>
              <li><a href="{{ url('/return_penjualan') }}" class="dropdown-item">Return Penjualan</a></li>
              <li><a href="{{ url('/return_pembelian') }}" class="dropdown-item">Return Pembelian</a></li>
              <li><a href="{{ url('/koreksi_stok') }}" class="dropdown-item">Koreksi Stok</a></li>
              
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Laporan</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ url('/laporan_penjualan') }}" class="dropdown-item">Laporan Penjualan </a></li>
              <li><a href="{{ url('/laporan_pembelian') }}" class="dropdown-item">Laporan Pembelian </a></li>
              <li><a href="{{ url('/laporan_return_penjualan') }}" class="dropdown-item">Laporan Return Penjualan</a></li>
              <li><a href="{{ url('/laporan_return_pembelian') }}" class="dropdown-item">Laporan Return Pembelian</a></li>
              <li><a href="{{ url('/laporan_koreksi_stok') }}" class="dropdown-item">Laporan Koreksi Stok</a></li>
              <li><a href="{{ url('/laporan_pajak') }}" class="dropdown-item">Laporan Pajak</a></li>
              <li><a href="{{ url('/laporan_komisi_dokter') }}" class="dropdown-item">Komisi Dokter</a></li>
              <li><a href="{{ url('/riwayat') }}" class="dropdown-item">Riwayat Sistem</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Master Data</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ url('/kategori_produk') }}" class="dropdown-item">Kategori Produk </a></li>
              <li><a href="{{ url('/produk') }}" class="dropdown-item">Produk </a></li>
              <li><a href="{{ url('/produsen') }}" class="dropdown-item">Produsen </a></li>
              <li><a href="{{ url('/supplier') }}" class="dropdown-item">Supplier </a></li>
              <li><a href="{{ url('/dokter') }}" class="dropdown-item">Dokter </a></li>
              <li><a href="{{ url('/customer') }}" class="dropdown-item">Customer</a></li>
              <li><a href="{{ url('/user') }}" class="dropdown-item">User</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Informasi</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="{{ url('/kontak_developer') }}" class="dropdown-item">Kontak Developer</a></li>
              <li><a href="{{ url('/tentang_sistem') }}" class="dropdown-item">Tentang Sistem</a></li>
            </ul>
          </li>
        </ul>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item dropdown">
            @php $user = Auth::user() @endphp
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fa fa-user"></i>{{ $user->name }}</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li>
                <a class="dropdown-item" href="{{ route('logout') }}"onclick="logout()">Logout</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </li>
            </ul>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper mt-5">
    <!-- Content Header (Page header) -->
    <div class="content-header">
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    @yield('konten')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      <b>System Developed By <a href="https://erait.id">EraIT</a></b>
    </div>
    <!-- Default to the left -->
    <strong>&copy; Template By <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Datatables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- Jquery Loading -->
<script src="{{ asset('plugins/jquery-loading/jquery.loading.min.js') }}"></script>
<!-- <script>
  $("body").loading({
    stoppable: true
  });
</script> -->
@yield('konten_js')
</body>
</html>
