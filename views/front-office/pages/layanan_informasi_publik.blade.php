@extends('front-office.layouts.master')

@section('title', 'Layanan Informasi Publik PPID Kementerian PPN/Bappenas')

@section('navbar')
  <x-navbar-front-office/>
@endsection

@section('topsection')
  <x-header-home-area/>
@endsection

@section('mainsection')
    <!-- ======= About Section ======= -->
  <div id="about" class="about-area container-fluid container-content laporan-layanan">
    <div class="container inner-content">
      <div class="row row-laporan-layanan">
        <div class="col-12">
          <h2 class="title box">
            <b>Laporan Layanan Informasi Publik</b> 
          </h2>
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
                  $cover = asset('img/laporan-layanan/default-1.jpg');
                endif;                 
              @endphp            
            <div class="col-12 col-sm-3 col-item">
                <div class="inner">
                  <div class="abs abs-text">
                    <div class="abs-inner">
                      <h5>
                        <a href="{{ $url }}" target="_blank">
                        {{ $row->judul }} 
                        </a>
                      </h5>                      
                    </div>
                  </div>

                  <img src="{{ $cover }}">
                </div>
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