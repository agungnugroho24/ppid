<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('assets/front-office/img/favicon.ico')}}" rel="icon">
  <link href="{{ asset('assets/front-office/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700|Raleway:300,400,400i,500,500i,700,800,900" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/front-office/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/front-office/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/front-office/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/front-office/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/front-office/vendor/nivo-slider/css/nivo-slider.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/front-office/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{ asset('assets/front-office/vendor/venobox/venobox.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/front-office/css/style.css')}}" rel="stylesheet">

  <!-- Datepicker Css -->
  <link href="{{ asset('assets/general/bootstrap-datepicker/css/bootstrap-datepicker.css')}}" rel="stylesheet">

  <!-- Datatables -->
  <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
  @stack('app-styles')  

</head>

<body data-spy="scroll" data-target="#navbar-example">

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex">

      <div class="logo mr-auto">
        <h1 class="text-light"><a href="{{ route('front-office') }}"><span>PPID </span></a></h1>
        <!-- Uncomment below if you prefer to use an image logo -->
         <!-- <a href="{{ route('front-office') }}"><img src="assets/front-office/img/logobappenas.png" alt="" class="img-fluid"></a> -->
      </div>
      @yield('navbar')

    </div>
  </header><!-- End Header -->

  <!-- ======= Slider Section ======= -->
    @yield('topsection')
  <!-- End Slider -->

  <main id="main">
    @yield('mainsection')
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer>
    <div class="footer-area">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="footer-content">
              <div class="footer-head">
                <div class="footer-logo">
                  <h2><span>PPID</span> Bappenas</h2>
                </div>

                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis.</p>
                <div class="footer-icons">
                  <ul>
                    <li>
                      <a href="#"><i class="fa fa-facebook"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-twitter"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-google"></i></a>
                    </li>
                    <li>
                      <a href="#"><i class="fa fa-pinterest"></i></a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- end single footer -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="footer-content">
              <div class="footer-head">
                <h4>information</h4>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.
                </p>
                <div class="footer-contacts">
                  <p><span>Tel:</span> +123 456 789</p>
                  <p><span>Email:</span> contact@example.com</p>
                  <p><span>Working Hours:</span> 9am-5pm</p>
                </div>
              </div>
            </div>
          </div>
          <!-- end single footer -->
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="footer-content">
              <div class="footer-head">
                <h4>Instagram</h4>
                <div class="flicker-img">
                  <a href="#"><img src="assets/front-office/img/portfolio/1.jpg" alt=""></a>
                  <a href="#"><img src="assets/front-office/img/portfolio/2.jpg" alt=""></a>
                  <a href="#"><img src="assets/front-office/img/portfolio/3.jpg" alt=""></a>
                  <a href="#"><img src="assets/front-office/img/portfolio/4.jpg" alt=""></a>
                  <a href="#"><img src="assets/front-office/img/portfolio/5.jpg" alt=""></a>
                  <a href="#"><img src="assets/front-office/img/portfolio/6.jpg" alt=""></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-area-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="copyright text-center">
              <p>
                <p> &copy; Copyright <?php echo date('Y');?>. All Rights Reserved</p>
                <p><strong>Pusat Data dan Informasi Perencanaan Pembangunan</strong></p> 
                <p><strong>Kementerian PPN/Bappenas</strong></p> 
              </p>
            </div>
            <!-- <div class="credits"> -->
              <!--
              All the links in the footer should remain intact.
              You can delete the links only if you purchased the pro version.
              Licensing information: https://bootstrapmade.com/license/
              Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=eBusiness
            -->
              <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
            <!-- </div> -->
          </div>
        </div>
      </div>
    </div>
  </footer><!-- End  Footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files {{ asset('')}}-->
  <script src="{{ asset('assets/front-office/vendor/jquery/jquery.min.js')}}"></script>
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
  <script src="{{ asset('assets/front-office/js/main.js')}}"></script>

  <!-- Datepicker Js -->
  <script src="{{ asset('assets/general/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
 
   <!-- Datatables -->
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>  
  @stack('app-script') 


</body>

</html>