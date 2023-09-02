@extends('front-office.layouts.master')

@section('title', 'Statistik Kunjungan Tamu PPID Kementerian PPN/Bappenas')

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
              <b>Statistik Kunjungan Tamu</b> 
            </h2>
          </div>                
          <div class="col-12 col-list">
            <ul class="list-group">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-1.jpg')}}" class="img-fluid" alt="Responsive image">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-2.jpg')}}" class="img-fluid" alt="Responsive image">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-3.jpg')}}" class="img-fluid" alt="Responsive image">
              <img src="{{ asset('img/laporan-akses/Akses-Informasi-Publik-Web-4.jpg')}}" class="img-fluid" alt="Responsive image">
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










<!--     <div id="about" class="about-area container-fluid container-content kunjungan-tamu">
      <div class="container inner-content">
        <div class="row">
          <div class="col-12 col-content">
            <div class="row row-statistik" id="statistik">
              <div class="col-12">
                <h2 class="title box">
                  <b>Statistik Kunjungan Tamu</b> 
                </h2>
              </div>

              <div class="col-12 container-slide">
                <div class="col-12 col-slide">
                  <div class="slide-image">
                    <img src="{{ asset('img/laporan-akses/akses-1.JPG')}}" alt="">
                  </div>
                </div>             
              </div>
            </div>      
          </div>
        </div>
      </div>
    </div> -->
    
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