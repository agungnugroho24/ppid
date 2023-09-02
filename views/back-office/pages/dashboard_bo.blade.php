@extends('back-office.layouts.master')

@section('title')
 {{ $title }}
@overwrite

@push('app-styles')
  <x-css-back-office/>
@endpush

@section('content')
<div class="section-header">
  <h1>{{ $title }}</h1>
</div>

<div class="section-body">
  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="far fa-user"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total User</h4>
          </div>
          <div class="card-body">
            {{$jumlah_user}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
          <i class="far fa-newspaper"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Permintaan Informasi</h4>
          </div>
          <div class="card-body">
            {{$jumlah_PI}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="far fa-file"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Permohonan Kunjungan</h4>
          </div>
          <div class="card-body">
            {{$jumlah_PK}}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success">
          <i class="fas fa-circle"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Pengajuan Keberatan</h4>
          </div>
          <div class="card-body">
            {{$jumlah_PKeb}}
          </div>
        </div>
      </div>
    </div>                  
  </div>

  <div class="row">
    <div class="col-lg-12 col-md-12 col-12 col-sm-12">
      <div class="card">
        <div class="card-header">
          <h4>Jumlah Pengunjung Website</h4>
        </div>
        <div class="card-body">
          <!--<canvas id="myChart" height="80"></canvas>-->
          <div id="container" style="width:93%;"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="{{asset('modules/highcharts.js')}}"></script>
{{-- <script src="{{asset('modules/exporting.js')}}"></script>
<script src="{{asset('modules/export-data.js')}}"></script>
<script src="{{asset('modules/accessibility.js')}}"></script> --}}
<script type="text/javascript">
    var visitor =  <?php echo json_encode($visitor) ?>;
   
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
         xAxis: {
            categories: [<?php echo date("Y"); ?>]
        },
        yAxis: {
            title: {
                text: 'Jumlah Pengunjung Website'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            },
            column: {
                pointPadding: 0.45,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Pengunjung Website',
            data: visitor
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 200
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
});
</script>
@endsection


@push('app-script')
<script> 

</script>
@endpush

