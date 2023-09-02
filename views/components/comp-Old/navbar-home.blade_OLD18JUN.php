<!-- ======= Header ======= -->
<header id="header" class="fixed-top window">
  <div class="container d-flex">

    <div class="logo mr-auto">
    <a href="{{ route('front-office') }}">
      <img src="{{ asset('img/top-bg.png')}}" alt="" class="img-fluid">
      <div style="float:right;line-height: 1.1;color:#ffffff;margin-top:2%;" class="title-header">
        <span class="title-navbar"> <b><i>Kementerian PPN/</i></b>
        </span><br>
        <span class="title-navbar subtitle"> <b><i>Bappenas</i></b>
        </span>
      </div>
    </a>
    </div>

    <nav class="nav-menu d-none d-lg-block">
      <ul>
        <li class=""><a href="{{ route('front-office') }}">Home</a></li>

        @if (Route::has('login'))
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarMyPage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            My Page
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarMyPage">
            @auth
              <a class="dropdown-item"  href="{{ route('home') }}" style="color:#165a64;">Dashboard</a>

              @if(Auth::user()->hasRole(['sekretariat', 'developer', 'super-administrator']))
              <a href="{{ route('back-office') }}" target="_blank" class="font-weight-bold dropdown-item"><span class="text-danger font-weight-bold">Back</span> <span class="text-dark">Office</span></a>
              @endif

              <a class="dropdown-item" href="{{ route('logout-custom') }}" style="color:#165a64;">Log Out</a>
            @else
              <a class="dropdown-item" href="{{ route('login') }}" style="color:#165a64;">Log in</a>

              @if (Route::has('register'))
              <a class="dropdown-item" href="{{ route('register') }}" style="color:#165a64;">Register</a>
              @endif
            @endauth
          </div>
        </li>
        @endif 

        @if (Route::has('login'))
          @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarRequest" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Request
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarRequest">
              <a class="dropdown-item" href="{{ route('informasi-publik') }}" style="color:#165a64;">Permohonan Informasi dan Data</a>               
              <a class="dropdown-item" href="{{ route('kunjungan-tamu') }}" style="color:#165a64;">Permohonan Kunjungan</a>               
              <a class="dropdown-item" href="{{ route('pengajuan-keberatan') }}" style="color:#165a64;">Pengajuan Keberatan Informasi Publik</a> 
            </div>
          </li> 

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarTracking" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Tracking
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarTracking">
              <a class="dropdown-item" href="{{ route('informasi-publik-progres') }}" style="color:#165a64;">Progres Permohonan Informasi dan Data</a>  
              <a class="dropdown-item" href="{{ route('kunjungan-tamu-progres') }}" style="color:#165a64;">Progres Permohonan Kunjungan</a>       
              <a class="dropdown-item" href="{{ route('pengajuan-keberatan-progres') }}" style="color:#165a64;">Progres Pengajuan Keberatan Informasi Publik</a> 
            </div>
          </li>
          <li class=""><a href="#">{{ Auth::user()->name }}</a></li>
          @endauth                      
        @endif  
      </ul>
    </nav>
    <!-- .nav-menu -->

  </div>
</header>
<!-- End Header -->

<!-- ======= Header ======= -->
<header id="header" class="fixed-top mobile">
  <div class="container d-flex">
    <div class="logo mr-auto">
      <h1 class="text-light"><a href="{{ route('front-office') }}"><span>e</span>-PPID</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
    </div>
    <nav class="nav-menu d-none d-lg-block">
      <ul>
        <li class=""><a href="{{ route('front-office') }}">Home</a></li>

        <li class="drop-down"><a href="#">My Page</a>
          <ul>
            @if (Route::has('login'))
              @auth
                <li><a href="{{ route('home') }}" style="color:#165a64;">Dashboard</a></li>
                
                @if(Auth::user()->hasRole(['sekretariat', 'developer']))
                  <li><a href="{{ route('back-office') }}" target="_blank"><span class="text-danger font-weight-bold">Back</span> <span class="text-dark">Office</span></a></li>
                @endif

                  <li><a href="{{ route('logout-custom') }}" style="color:#165a64;">Log Out</a></li>
              @else
                  <li><a href="{{ route('login') }}" style="color:#165a64;">Log in</a></li>
                
                @if (Route::has('register'))
                  <li><a href="{{ route('register') }}" style="color:#165a64;">Register</a></li>
                @endif
              @endauth
            @endif
          </ul>
        </li>

        @if (Route::has('login'))
          @auth
          <li class="drop-down"><a href="#">Request</a>
            <ul>
              <li><a href="{{ route('informasi-publik') }}" style="color:#165a64;">Permohonan Informasi dan Data</a></li>
              <li><a href="{{ route('kunjungan-tamu') }}" style="color:#165a64;">Permohonan Kunjungan</a></li>
              <li><a href="{{ route('pengajuan-keberatan') }}" style="color:#165a64;">Pengajuan Keberatan Informasi Publik</a></li>
            </ul>
          </li>
          <li class="drop-down"><a href="#">Tracking</a>
            <ul>
              <li><a href="{{ route('informasi-publik-progres') }}" style="color:#165a64;">Progres Permohonan Informasi dan Data</a></li>
              <li><a href="{{ route('kunjungan-tamu-progres') }}" style="color:#165a64;">Progres Permohonan Kunjungan</a></li>
              <li><a href="{{ route('pengajuan-keberatan-progres') }}" style="color:#165a64;">Progres Pengajuan Keberatan Informasi Publik</a></li>
            </ul>
          </li>
          <li class=""><a href="#">{{ Auth::user()->name }}</a></li>    
          @endauth                      
        @endif            

      </ul>
    </nav><!-- .nav-menu -->
  </div>
</header><!-- End Header
