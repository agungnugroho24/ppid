@extends('front-office.layouts.master')

@section('title', 'Tugas Dan Fungsi PPID Kementerian PPN/Bappenas')

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
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="section-headline text-center">
          <h2>Tugas dan Fungsi</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- single-well start-->
    @isset($data)  
    @foreach($data as $row)
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="well-middle">
          <div class="single-well">
            <a href="#">
              <h4 class="sec-head">{{ $row->judul }}</h4>
            </a>
            {!!$row->isi_konten!!}
          </div>
        </div>
      </div>
    @endforeach
    @endisset
      <!-- single-well end-->
<!--       <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="well-middle">
          <div class="single-well">

            <a href="#">
              <h4 class="sec-head">FUNGSI</h4>
            </a>


            <ul>
              <li>
                <i class="fa fa-caret-right"></i> Merencanakan, mengorganisasikan, melaksanakan, mengawasi, dan mengevaluasi pelaksanaan kegiatan pengelolaan informasi dan dokumentasi di Kementerian PPN/Bappenas.
              </li>
              <li>
                <i class="fa fa-caret-right"></i> Melakukan koordinasi dengan pihak terkait dalam pengelolaan informasi dan dokumentasi.
              </li>
              <li>
                <i class="fa fa-caret-right"></i> Mewakili Kementerian PPN/Bappenas dalam menyampaikan informasi kepada publik. 
              </li>
            </ul>

          </div>
        </div>
      </div> -->
      <!-- End col-->
    </div>
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