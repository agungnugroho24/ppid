@extends('front-office.layouts.master')

@section('title', 'Mekanisme Permohonan PPID Kementerian PPN/Bappenas')

@section('navbar')
  <x-navbar-front-office/>
@endsection

@section('topsection')
  <x-header-home-area/>
@endsection

@section('mainsection')
    <!-- ======= About Section ======= -->
    <div id="about" class="about-area area-padding">
      <div class="container">
        @isset($data)
        @foreach($data as $row)
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="section-headline text-center">
              <h2>{{$row->judul}}</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- single-well start-->
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="text-center">
              <div class="single-well">
                  {!!$row->isi_konten!!}
                  <!-- <img src="{{ asset('img/mekanisme.jpeg')}}" alt=""> -->
              </div>
            </div>
          </div>
        </div>
        @endforeach
        @endisset
      </div>
    </div><!-- End About Section -->
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