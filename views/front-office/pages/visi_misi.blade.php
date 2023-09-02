@extends('front-office.layouts.master')

@section('title', 'Visi Dan Misi PPID Kementerian PPN/Bappenas')

@section('navbar')
  <x-navbar-front-office/>
@endsection

@section('topsection')
  <x-header-home-area/>
@endsection

@section('mainsection')
    <!-- ======= About Section ======= -->
    <div id="about" class="area-padding">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="section-headline text-center">
              <h2>Visi dan Misi</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="section-headline text-center">
    @isset($data)  
    @foreach($data as $row)
              <div class="single-well">
                <a href="#">
                  @if(strtolower($row->judul) == "visi")
                  <h4 class="sec-head">{{$row->judul}}</h4>
                </a>
                <p>
                  {!! $row->isi_konten !!}
                </p>
                  @endif
              </div>
    @endforeach
    @endisset              
            </div>
          </div>
        </div>
      </div>
      <br>
      <div class="container">
    @isset($data)  
    @foreach($data as $row)
      @if(strtolower($row->judul) == "misi")
        <div class="row">
          <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="section-headline text-center">
              <div class="single-well">
                <a href="#">
                  <h4 class="sec-head">{{$row->judul}}</h4>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-lg-12">
          <div class="well-middle">
            <div class="single-well text-justify">
              {!! $row->isi_konten !!}
<!--               <ul>
                <li>
                  <i class="fa fa-caret-right"></i> Menyediakan kegiatan pelayanan informasi publik dengan mengedepankan prinsip kemudahan, kecepatan, dan keakuratan, sesuai dengan standar pelayanan Informasi Publik.
                </li>
                <li>
                  <i class="fa fa-caret-right"></i> Menyediakan sumber daya manusia dan infrastruktur pelayanan informasi yang memadai untuk terlaksananya kegiatan pelayanan Informasi Publik.
                </li>
                <li>
                  <i class="fa fa-caret-right"></i> Memberikan pelayanan kepada setiap pemohon informasi publik secara transparan dan bertanggung jawab.
                </li>
              </ul> -->

            </div>
          </div>
        </div>
      @endif  
    @endforeach
    @endisset        
        <!-- End col-->
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