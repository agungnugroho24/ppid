@extends('front-office.layouts.master')

@section('title', config('app.name'))

@section('navbar')
  <x-navbar-front-office/>
@endsection

@section('topsection')
  <x-slider-front-office/>
@endsection

@section('mainsection')
    <!-- ======= Portfolio Section ======= -->
    <div id="portfolio" class="portfolio-area area-padding fix" style="margin-top: -2.5%;background-color:#a2a2a2">
      <div class="container">
        <div class="row awesome-project-content">
          <!-- single-awesome-project start -->
          <div class="col-md-4 col-sm-4 col-xs-12 design development">
            <div class="single-awesome-project">
              <div class="team-content text-center">
                <h5 style="color: #ffffff">Berkala</h5>
              </div>
              <div class="shadow-3 text-center">
                <a href="/ppid/informasiberkala"><img src="{{ asset('img/icon-berkala.png')}}" height="100" width="100" class="{{--shadow p-3 mb-5 bg-white rounded--}}" alt="" /></a>
              </div>
            </div>
          </div>
          <!-- single-awesome-project end -->
          <!-- single-awesome-project start -->
          <div class="col-md-4 col-sm-4 col-xs-12 photo">
            <div class="single-awesome-project">
              <div class="team-content text-center">
                <h5 style="color: #ffffff">Serta Merta</h5>
              </div>
              <div class="shadow-3 text-center">
                <a href="/ppid/informasisertamerta"><img src="{{ asset('img/icon-serta-merta.png')}}" height="100" width="100" class="{{--shadow p-3 mb-5 bg-white rounded--}}" alt="" /></a>
              </div>
            </div>
          </div>
          <!-- single-awesome-project end -->
          <!-- single-awesome-project start -->
          <div class="col-md-4 col-sm-4 col-xs-12 design">
            <div class="single-awesome-project">
              <div class="team-content text-center">
                <h5 style="color: #ffffff">Setiap Saat</h5>
              </div>
              <div class="shadow-3 text-center">
                <a href="/ppid/informasisetiapsaat"><img src="{{ asset('img/icon-setiap-saat.png')}}" height="100" width="100" class="{{--shadow p-3 mb-5 bg-white rounded--}}" alt="" /></a>
              </div>
            </div>
          </div>
          <!-- single-awesome-project end -->
        </div>
      </div>
    </div><!-- End Portfolio Section -->

    <div class="footer-area">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="footer-content">
              <div class="footer-head">
                <div class="footer-logo">
                  <h4 class="text-center">Jumlah statistik</h4>
                </div>
                <div class="row">
                  <div class="col-md-12 col-sm-12 col-lg-12">
                    <div class="pri_table_list shadow p-3 mb-5 bg-white rounded">
                      <h5>Jumlah Permohonan Informasi</h5>
                        <b><h5>100</h5></b>
                    </div>
                    <div class="pri_table_list shadow p-3 mb-5 bg-white rounded">
                      <h5>Jumlah Kunjungan Tamu</h5>
                        <b><h5>200</h5></b>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- end single footer -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="footer-content">
              <div class="footer-head">
                <h4 class="text-center">Publikasi</h4>
                <div class="gallery"> 
                  <a href="https://www.bappenas.go.id/id/data-dan-informasi-utama/publikasi/rencana-pembangunan-dan-rencana-kerja-pemerintah/" target="_blank" data-caption="Pembangunan dan Rencana Kerja Pemerintah">
                    <img id="img1" src="{{ asset('img/rencana-pembangunan-dan-rencana-kerja-pemerintah.jpg')}}" height="250" width="300" style="border: #000000 1px solid;"/>
                  </a> 
                  <a href="https://www.bappenas.go.id/id/data-dan-informasi-utama/publikasi/lampiran-pidato-kenegaraan-presiden-ri/" target="_blank" data-caption="Lampiran Pidato Kenegaraan Presiden RI">
                    <img id="img1" src="{{ asset('img/lampiran-pidato-kenegaraan-presiden-ri.jpg')}}" height="250" width="300" style="border: #000000 1px solid;"/>
                  </a> 
                  <a href="https://www.bappenas.go.id/evaluasi-perencanaan-pembangunan" target="_blank" data-caption="Evaluasi Perencanaan Pembangunan">
                    <img id="img1" src="{{ asset('img/evaluasi-perencanaan-pembangunan.jpg')}}" height="250" width="300" style="border: #000000 1px solid;"/>
                  </a> 
                  <a href="https://www.bappenas.go.id/panduan-perencanaan-pembangunan" target="_blank" data-caption="Panduan Perencanaan Pembangunan">
                    <img id="img1" src="{{ asset('img/panduan-perencanaan-pembangunan.jpg')}}" height="250" width="300" style="border: #000000 1px solid;"/>
                  </a> 
                  <a href="https://www.bappenas.go.id/majalah-perencanaan-pembangunan" target="_blank" data-caption="Majalah Perencanaan Pembangunan">
                    <img id="img1" src="{{ asset('img/majalah-perencanaan-pembangunan.jpg')}}" height="250" width="300" style="border: #000000 1px solid;"/>
                  </a> 
                  <a href="https://www.bappenas.go.id/policy-paper" target="_blank" data-caption="Policy Paper">
                    <img id="img1" src="{{ asset('img/policy-paper.jpg')}}" height="250" width="300" style="border: #000000 1px solid;"/>
                  </a> 
                  <a href="https://www.bappenas.go.id/id/data-dan-informasi-utama/publikasi/drpln-jm-dan-drpphln/" target="_blank" data-caption="DRPLN-JM, DRPPLN, DRKH, dan RPPLN (Blue Book dan Green Book)">
                    <img id="img1" src="{{ asset('img/drpln-jm-dan-drpphln.jpg')}}" height="250" width="300" style="border: #000000 1px solid;"/>
                  </a> 
                  <a href="https://www.bappenas.go.id/laporan-kinerja-pelaksanaan-pinjamanhibah-luar-negeri" target="_blank" data-caption="Laporan Kinerja Pelaksanaan Pinjaman/Hibah Luar Negeri">
                    <img id="img1" src="{{ asset('img/laporan-kinerja-pelaksanaan-pinjamanhibah-luar-negeri.jpg')}}" height="250" width="300" style="border: #000000 1px solid;"/>
                  </a> 
                  <a href="https://www.bappenas.go.id/peraturan-dan-perundang-undangan" target="_blank" data-caption="Peraturan dan Perundang-Undangan">
                    <img id="img1" src="{{ asset('img/peraturan-dan-perundang-undangan.jpg')}}" height="250" width="300" style="border: #000000 1px solid;"/>
                  </a> 
                  <a href="https://www.bappenas.go.id/id/data-dan-informasi-utama/publikasi/paket-kebijakan-ekonomi" target="_blank" data-caption="Paket Kebijakan Ekonomi">
                    <img id="img1" src="{{ asset('img/paket-kebijakan-ekonomi.jpg')}}" height="250" width="300" style="border: #000000 1px solid;"/>
                  </a> 
                </div>
                <div class="text-center"> 
                  <a href="#" class="btn prev"><button class="btn btn-sm btn-primary">Prev</button></a>
                  <a href="#" class="btn next"><button class="btn btn-sm btn-primary">Next</button></a>
                </div>
              </div>
            </div>
          </div>
          <!-- end single footer -->
          <div class="col-12 col-sm-4 col-twitter-feed">
            <div class="footer-content">
              <div class="footer-head">
                <div class="footer-logo">
                  <h4 class="text-center">Instagram</h4>
                </div>
              </div>
            </div>
            <iframe src="https://www.socialmediawall.io/wall/88584/" frameborder="0" width="100%" height="430px"></iframe>
          </div>
        </div>
      </div>
    </div>

    <!-- ======= Skills Section ======= -->
    <div class="skill-bg area-padding-2">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="section-headline text-center">
          <h2 style="font-size: 2em">Layanan Lainnya</h2>
        </div>
      </div>
      <br><br>
      <div class="col-lg-12 col-12">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-lg-2 gallery-item">
                <a href="http://bappenas.go.id/" target="_blank" class="link-gallery" >
                  <h6 class="mb-1 text-center" style="color: #000000;font-size:150%;font-family:'Lucida Handwriting',cursive;">Bappenas</h6>
                </a>
              </div> <!-- /.col -->
              
              <div class="col-lg-2 gallery-item">
                <a href="http://perpustakaan.bappenas.go.id/" target="_blank" class="link-gallery">
                  <h6 class="mb-1 text-center" style="color: #000000;font-size:150%;font-family:'Lucida Handwriting',cursive;">Perpustakaan</h6>
                </a>
              </div> <!-- /.col -->
              
              <div class="col-lg-2 gallery-item" style="padding-left:6%;">
                <a href="http://birohukum.bappenas.go.id/" target="_blank" class="link-gallery">
                  <h6 class="mb-1 text-center" style="color: #000000;font-size:150%;font-family:'Lucida Handwriting',cursive;">Biro Hukum</h6>
                </a>
              </div> <!-- /.col -->
              
              <div class="col-lg-2 gallery-item">
                <a href="http://lapor.go.id" target="_blank" class="link-gallery">
                  <h6 class="mb-1 text-center" style="color: #000000;font-size:150%;font-family:'Lucida Handwriting',cursive;">SP4N Lapor</h6>
                </a>
              </div> <!-- /.col -->
              
              <div class="col-lg-2 gallery-item">
                <a href="http://irtama.bappenas.go.id" target="_blank" class="link-gallery">
                  <h6 class="mb-1 text-center" style="color: #000000;font-size:150%;font-family:'Lucida Handwriting',cursive;">WBS</h6>
                </a>
              </div> <!-- /.col -->
            </div> <!--/.row  -->
          </div> <!-- /.container -->
      </div>
    </div>


    <!-- Trigger the modal with a button -->
    {{-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> --}}

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="5" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title w-100 text-center" id="myModalLabel">Informasi Permohonan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                  <div class="col-12 col-step-icon">
                    <div class="row row-step-icon">
                      <div class="col-12 col-sm-4 col-icon-item">
                        <img src="{{ asset('img/img-pemohon.png')}}">
                        <p>
                          <b>
                            Lorem ipsum dolor
                          </b>
                        </p>
                        <p>
                          consectetur adipisicing elit, sed do eiusmod
                          tempor incididunt ut labore et dolore magna aliqua. 
                          Ut enim ad minim veniam.
                        </p>
                      </div>
                      <div class="col-12 col-sm-4 col-icon-item">
                        <img src="{{ asset('img/img-ppid.png')}}">
                        <p>
                          <b>
                            Lorem ipsum dolor
                          </b>
                        </p>
                        <p>
                          consectetur adipisicing elit, sed do eiusmod
                          tempor incididunt ut labore et dolore magna aliqua. 
                          Ut enim ad minim veniam.
                        </p>
                      </div>
                      <div class="col-12 col-sm-4 col-icon-item">
                        <img src="{{ asset('img/img-informasi.png')}}">
                        <p>
                          <b>
                            Lorem ipsum dolor
                          </b>
                        </p>
                        <p>
                          consectetur adipisicing elit, sed do eiusmod
                          tempor incididunt ut labore et dolore magna aliqua. 
                          Ut enim ad minim veniam.
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="modal-footer remove-top">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal -->

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