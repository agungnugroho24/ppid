@extends('front-office.layouts.master')

@section('title', 'Survei Layanan Informasi Publik PPID Kementerian PPN/Bappenas')

@section('navbar')
  <x-navbar-front-office/>
@endsection

@section('topsection')
  <x-header-home-area/>
@endsection

@section('mainsection')
    <!-- ======= About Section ======= -->
  <div id="about" class="about-area container-fluid container-content laporan-survey">
    <div class="container inner-content">
      <div class="row row-laporan-survey">
        <div class="col-12">
          <h3 class="title box">
            <b>Laporan Survey Layanan Informasi Publik</b>  
          </h3>
        </div>

        <div class="col-12 col-list">
          <div class="row row-list">
            @isset($data)
            @foreach($data as $row)
              @php
                if(!empty($row->data_file)):
                  $url = asset('storage/post_laporan/'.$row->data_file);
                else:
                  $url = route('front-office');
                endif;

                if(!empty($row->cover_image)):
                  $cover = asset('storage/post_laporan/'.$row->cover_image);
                else:
                  $cover = asset('img/laporan-layanan/default-2.jpg');
                endif;                
              @endphp            
            <div class="col-lg-4 col-md-3 col-sm-6 col-item text-center mb-4">
              <a href="{{ $url }}" target="_blank">
                <img src="{{ $cover }}">
              </a>
            </div>
            @endforeach
            @endisset  

            @isset($data)
            <div>
              {{ $data->links() }}
            </div>
            @endisset                       

          </div>
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