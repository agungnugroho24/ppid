  <!-- ======= Footer ======= -->
  <footer>
    <!-- ======= Contact Section ======= -->
    <div class="footer-area contact-area">
      <div class="contact-inner area-padding">
        <div class="contact-overly"></div>
        <div class="container ">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="section-headline text-center">
                <h2 style="font-size: 2em">Kontak</h2>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- Start contact icon column -->
            <div class="col-md-3 col-sm-3 col-xs-12">
              <div class="contact-icon text-center">
                <div class="single-icon">
                  <!-- <i class="fa fa-mobile"></i> -->
                  <i class="fab fa-whatsapp"></i>
                  <p>
                    Call: (021) 319 28277<br>
                  </p>
                </div>
              </div>
            </div>
            <!-- Start contact icon column -->
            <div class="col-md-3 col-sm-3 col-xs-12">
              <div class="contact-icon text-center">
                <div class="single-icon">
                  <i class="fa fa-envelope-o"></i>
                  <p>
                    Email: ppid@bappenas.go.id
                  </p>
                </div>
              </div>
            </div>
            <!-- Start contact icon column -->
            <div class="col-md-3 col-sm-3 col-xs-12">
              <div class="contact-icon text-center">
                <div class="single-icon">
                  <i class="fa fa-map-marker"></i>
                  <p>
                    Gedung Wisma Bakrie 2, Lantai 2, Jl. HR Rasuna Said, Kuningan, Karet, Setiabudi, Jakarta Selatan, Daerah Khusus Ibukota Jakarta, 12920.
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <div class="contact-icon text-center">
                <h4>Sosial Media Kami :</h4>
                <div class="footer-icons">
                  <ul>
                    <li>
                      <a href="https://www.facebook.com/bappenas/" target="_blank"><img src="{{ asset('img/icon-sosmed/facebook-1.png') }}" width="25" height="25"></a>
                    </li>
                    <li>
                      <a href="https://twitter.com/BappenasRI" target="_blank"><img src="{{ asset('img/icon-sosmed/twitter.png') }}" width="25" height="25"></a>
                    </li>
                    <li>
                      <a href="https://www.instagram.com/bappenasri" target="_blank"><img src="{{ asset('img/icon-sosmed/instagram.png') }}" width="25" height="25"></a>
                    </li>
                    <li>
                      <a href="https://www.youtube.com/channel/UCx-7i_Oqg5pDX_2EBG_XpeQ" target="_blank"><img src="{{ asset('img/icon-sosmed/youtube-1.png') }}" width="25" height="25"></a>
                    </li>
                    <li>
                      <a href="https://api.whatsapp.com/send/?phone=6281211002143&text&app_absent=0" target="_blank"><img src="{{ asset('img/icon-sosmed/whatsapp.png') }}" width="25" height="25"></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End Contact Section -->
    <div class="footer-area-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="copyright text-center">
              <p>
                &copy; Copyright <?php echo date('Y');?>. <strong>Kementerian PPN/Bappenas.</strong>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer><!-- End  Footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  <button type="button" class="" onclick="topFunction()" id="alur" title="" data-toggle="modal" data-target="#myModal">
    <span class="noselect">Alur Informasi</span><div id="circle"></div>
  </button>

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

  <!-- Vendor JS Files -->
  <!-- <script src="{{ asset('assets/front-office/vendor/jquery/jquery.min.js')}}"></script> -->
  <script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>

  <script src="{{ asset('assets/front-office/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/appear/jquery.appear.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/knob/jquery.knob.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/parallax/parallax.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/wow/wow.min.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/nivo-slider/js/jquery.nivo.slider.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('assets/front-office/vendor/venobox/venobox.min.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('js/main.js') }}"></script>

  <!-- Custom JS -->
  <script src="{{ asset('js/jquery.flipping_gallery.js') }}"></script>

  <!-- Datepicker Js -->
  <script src="{{ asset('assets/general/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
 
   <!-- Datatables -->
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 

  <!-- Select 2   -->
  <script src="{{ asset('assets/general/select2/dist/js/select2.min.js') }}"></script>   

<script>
  //Get the button
  var mybutton = document.getElementById("alur");

  // When the user scrolls down 20px from the top of the document, show the button
  window.onscroll = function() {scrollFunction()};

  function scrollFunction() {
    if (document.body.scrollTop == 0 || document.documentElement.scrollTop == 0) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  }

  // When the user clicks on the button, scroll to the top of the document
  function topFunction() {
    // document.body.scrollTop = 0;
    // document.documentElement.scrollTop = 0;
  }

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
