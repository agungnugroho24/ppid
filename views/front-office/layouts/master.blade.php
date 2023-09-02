<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>@yield('title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  
  <x-link-css-front-office/>
  <x-css-front-office/>
  <x-css-laporan-front-office/>
  @stack('app-styles') 

</head>
<body data-spy="scroll" data-target="#navbar-example">
  <!-- ======= Navbar Section ======= -->
  @yield('navbar')

  <!-- ======= Slider Section ======= -->
  @yield('topsection')

  <!-- ======= Main Section ======= -->
  <main id="main">
    @yield('mainsection')
  </main><!-- End #main -->

  <!-- ======= Footer Section ======= -->

  @include('front-office.pages.partial.footer')
  @stack('app-script')
  @include('sweetalert::alert')

</body>
</html>