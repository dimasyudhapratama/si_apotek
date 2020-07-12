@extends('master_template')

@section('konten')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h4 class="font-weight-bold">Penjualan</hb>
                        <p>{{ date('d-m-Y') }}</p>
                        <p id="scorecard_penjualan_harian"></p>
                    </div>
                    <a href="{{ url('/laporan_penjualan') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h4 class="font-weight-bold">Pembelian</hb>
                        <p>{{ date('d-m-Y') }}</p>
                        <p id="scorecard_pembelian_harian"></p>
                    </div>
                    <a href="{{ url('/laporan_pembelian') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h4 class="font-weight-bold">Return Penjualan</hb>
                        <p>{{ date('d-m-Y') }}</p>
                        <p id="scorecard_return_penjualan_harian"></p>
                    </div>
                    <a href="{{ url('/laporan_return_penjualan') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small card -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h4 class="font-weight-bold">Return Pembelian</hb>
                        <p>{{ date('d-m-Y') }}</p>
                        <p id="scorecard_return_pembelian_harian"></p>
                    </div>
                    <a href="{{ url('/laporan_return_pembelian') }}" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Grafik Harian (Bulan {{ date('M-Y') }})</b></h5>
                    </div>
                    <div class="card-body">
                        <canvas id="dailyChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0"><b>Grafik Bulanan (Tahun {{ date('Y') }})</b></h5>
                    </div>
                    <div class="card-body">
                        <canvas id="monthlyChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

@section('konten_js')
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script>
    //Initialization - Loaded First
    $(function () {
        $("#alert_").hide();
    });
    
    //CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
  $(function () {
    getDailyScoreCard()
    previewDailyChart()
    previewMonthlyChart()
  })

  //Ajax untuk Menampilkan Pendapatan Harian
  function getDailyScoreCard(){
    $.ajax({
        url: "{{ url('/dashboard/daily_scorecard') }}",
        type: "GET",
        success: function(data) {
          console.log(data)
          $("#scorecard_penjualan_harian").text("Rp. "+data['penjualan']);
          $("#scorecard_pembelian_harian").text("Rp. "+data['pembelian']);
          $("#scorecard_return_penjualan_harian").text("Rp. "+data['return_penjualan']);
          $("#scorecard_return_pembelian_harian").text("Rp. "+data['return_pembelian']);
          
        }
    });  
  }

  //Ajax untuk Menampilkan Line Chart Secara Harian
  function previewDailyChart(){
    $.ajax({
        url: "{{ url('/dashboard/daily_chart') }}",
        type: "GET",
        success: function(dataset) {

          var tanggal_int = 1;
          var tanggal_array = [];
          var data_penjualan = [];
          var data_pembelian = [];
          var data_return_penjualan = [];
          var data_return_pembelian = [];

          for(var i=0;i<dataset.length;i++){
              tanggal_array.push(tanggal_int);
              data_penjualan.push(dataset[i]['data_penjualan']);
              data_pembelian.push(dataset[i]['data_pembelian']);
              data_return_penjualan.push(dataset[i]['data_return_penjualan']);
              data_return_pembelian.push(dataset[i]['data_return_pembelian']);

              tanggal_int++;
          }

          var ctx = document.getElementById("dailyChart").getContext('2d');
          var myChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: tanggal_array,
                  datasets: [{
                      label: 'Penjualan',
                      data: data_penjualan,
                      fill: false,
                      borderColor: '#2196f3',
                      backgroundColor: '#2196f3',
                      borderWidth: 1
                  },
                  {
                      label: 'Pembelian',
                      data: data_pembelian,
                      fill: false,
                      borderColor: '#4CAF50',
                      backgroundColor: '#4CAF50',
                      borderWidth: 1
                  },
                  {
                      label: 'Return Penjualan',
                      data: data_return_penjualan,
                      fill: false,
                      borderColor: '#db1a09', 
                      backgroundColor: '#db1a09',
                      borderWidth: 1
                  },
                  {
                      label: 'Return Pembelian',
                      data: data_return_pembelian,
                      fill: false,
                      borderColor: '#E5AD06',
                      backgroundColor: '#E5AD06',
                      borderWidth: 1 
                  }]
              },         
              options: {
                responsive: true, 
                maintainAspectRatio: false, 
              }
          });
        }
    });
  }

  //Ajax untuk Menampilkan Line Chart Secara Bulanan
  function previewMonthlyChart(){
    $.ajax({
        url: "{{ url('/dashboard/monthly_chart') }}",
        type: "GET",
        success: function(dataset) {
          // console.log(dataset)
          
          var data_penjualan = [];
          var data_pembelian = [];
          var data_return_penjualan = [];
          var data_return_pembelian = [];

          for(var i=0;i<dataset.length;i++){
              data_penjualan.push(dataset[i]['data_penjualan']);
              data_pembelian.push(dataset[i]['data_pembelian']);
              data_return_penjualan.push(dataset[i]['data_return_penjualan']);
              data_return_pembelian.push(dataset[i]['data_return_pembelian']);
          }

          var ctx = document.getElementById("monthlyChart").getContext('2d');
          var myChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                  datasets: [{
                      label: 'Penjualan',
                      data: data_penjualan,
                      // data: [1,2,3,4,5,6,7,8,9,10,11,12],
                      fill: false,
                      borderColor: '#2196f3',
                      backgroundColor: '#2196f3',
                      borderWidth: 1
                  },
                  {
                      label: 'Pembelian',
                      data: data_pembelian,
                      fill: false,
                      borderColor: '#4CAF50',
                      backgroundColor: '#4CAF50',
                      borderWidth: 1
                  },
                  {
                      label: 'Return Penjualan',
                      data: data_return_penjualan,
                      fill: false,
                      borderColor: '#db1a09', 
                      backgroundColor: '#db1a09',
                      borderWidth: 1
                  },
                  {
                      label: 'Return Pembelian',
                      data: data_return_pembelian,
                      fill: false,
                      borderColor: '#E5AD06',
                      backgroundColor: '#E5AD06',
                      borderWidth: 1 
                  }]
              },         
              options: {
                responsive: true, 
                maintainAspectRatio: false, 
              }
          });
        }
    });
  }
</script>
@endsection