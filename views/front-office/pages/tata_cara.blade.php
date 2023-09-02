@extends('front-office.layouts.master')

@section('title', 'Tata Cara PPID Kementerian PPN/Bappenas')

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
          <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="section-headline text-center">
              <h2>Tata Cara</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="section-headline text-justify">
              <div class="single-well">

                @isset($data)
                @foreach($data as $row)
                <div class="card mb-4 card-ppid-custom" style="border:none;">
                  <h4 class="card-header text-justify header-card-custom" >{{$row->judul}}</h4>
                  <div class="card-body">
                    <p class="card-text">
                      {!!$row->konten_pendek!!}
                    </p>
                    <a href="{{ route('show-tatacara', $row->uuid_code) }}" target="_blank" class="btn btn-outline-secondary float-right" style="padding: 6px 18px 6px 18px;font-size: 14px;border-radius:20px;">Baca lebih lanjut &nbsp;<i class="fa fa-angle-double-right"></i></a>
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
    </div>
    <!-- End About Section -->
@endsection

@push('app-script')
<script>
$( document ).ready(function() {
  if (document.cookie.indexOf('visited=true') == -1){
    // load the overlay
    $('#myModal').modal({show:true});
    
    var year = 1000*60*60*24*365;
    var expires = new Date((new Date()).valueOf() + year);
    document.cookie = "visited=true;expires=" + expires.toUTCString();
  }

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

  $('.card-ppid-custom').mouseover(function(e){
    $(this).addClass('card-custom-hover');
  });

  $('.card-ppid-custom').mouseleave(function(e){
    $(this).removeClass('card-custom-hover');
  });  

}); 
</script>
@endpush