@extends('front-office.layouts.master')

@section('title', 'Akses Informasi Publik PPID Kementerian PPN/Bappenas')

@section('navbar')
  <x-navbar-front-office/>
@endsection

@section('topsection')
  <x-header-home-area/>
@endsection

@section('mainsection')
    <!-- ======= About Section ======= -->
    <div id="about" class="about-area container-fluid container-content laporan-akses">
      <div class="container inner-content">
        <div class="row row-laporan-akses">
          <div class="col-12 col-list">
            <h2 class="title box">
              <b>Laporan Akses Informasi Publik</b> 
            </h2>
          </div>  
          <div class="col-12 col-list">
            <div class="alert alert-dark text-center font-weight-bold" role="alert">
              Tahun 2021
            </div>
            <ul class="list-group">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-5.jpeg')}}" class="img-fluid" alt="Responsive image">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-6.jpeg')}}" class="img-fluid" alt="Responsive image">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-7.jpeg')}}" class="img-fluid" alt="Responsive image">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-8.jpeg')}}" class="img-fluid" alt="Responsive image">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-11.jpeg')}}" class="img-fluid" alt="Responsive image">
            </ul>
          </div>
          <div class="col-12 col-list">
            <div class="alert alert-dark text-center font-weight-bold" role="alert">
              Tahun 2020
            </div>
            <ul class="list-group">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-1.jpg')}}" class="img-fluid" alt="Responsive image">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-2.jpg')}}" class="img-fluid" alt="Responsive image">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-3.jpg')}}" class="img-fluid" alt="Responsive image">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-4.jpg')}}" class="img-fluid" alt="Responsive image">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-10.jpeg')}}" class="img-fluid" alt="Responsive image">
              {{-- @isset($data)
              @foreach($data as $row)              
              <li class="list-group-item">
                @php
                  if(!empty($row->data_file)):
                    $url = asset('storage/post_laporan/'.$row->data_file);
                  else:
                    $url = route('front-office');
                  endif;
                @endphp
                <a href="{{ $url }}" target="_blank">  
                  {{$row->judul}}
                </a>
              </li>
              @endforeach
              @endisset  
              
              @isset($data)
              <div>
                {{ $data->links() }}
              </div>
              @endisset                           --}}

            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- End About Section -->
@endsection

@push('app-script')
<script>
$(document).ready( function() {
  $(".gallery").flipping_gallery({
    enableScroll: true,
    autoplay: 5000
  });
  
  $(".next").click(function() {
    $(".gallery").flipForward();
    return false;
  });
  $(".prev").click(function() {
    $(".gallery").flipBackward();
    return false;
  });
});

// $( document ).ready() block.
$( document ).ready(function() {
  if (document.cookie.indexOf('visited=true') == -1){
    // load the overlay
    $('#myModal').modal({show:true});
    
    var year = 1000*60*60*24*365;
    var expires = new Date((new Date()).valueOf() + year);
    document.cookie = "visited=true;expires=" + expires.toUTCString();

  }
}); 
</script>
@endpush