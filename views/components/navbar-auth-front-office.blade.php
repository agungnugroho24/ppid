<!-- ======= Header ======= -->
<header id="header" class="fixed-top window">
  <div class="container d-flex">

    <div class="mr-auto">
    <!-- Uncomment below if you prefer to use an image logo -->
    <a href="{{ route('front-office') }}">
      <img src="{{ asset('img/new-logo.png')}}" alt="" class="img-fluid" style="height:60px;width:160px;margin-top:-7.5%;">
      {{-- <div style="float:right;line-height: 1.1;color:#ffffff;margin-top:2%;" class="title-header">
        <span class="title-navbar"> <b><i>Kementerian PPN/</i></b>
        </span><br>
        <span class="title-navbar subtitle"> <b><i>Bappenas</i></b>
        </span>
      </div> --}}
    </a>
    </div>

    <nav class="nav-menu d-none d-lg-block">
      <ul>
        <li class=""><a href="{{ route('front-office') }}">Home</a></li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarMyPage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            My Page
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarMyPage">
            @if (Route::has('login'))
              @auth
                <a class="dropdown-item" href="{{ route('logout-custom') }}" style="color:#165a64;">Log Out</a>
              @else
   
                <a class="dropdown-item" href="{{ route('login') }}" style="color:#165a64;">Log in</a>
                @if (Route::has('register'))
                  <a class="dropdown-item" href="{{ route('register') }}" style="color:#165a64;">Register</a>
                @endif 
              @endauth
            @endif 
          </div>
        </li>
      </ul>
    </nav>
      <!-- .nav-menu -->
  </div>
</header><!-- End Header -->

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
      </ul>
    </nav><!-- .nav-menu -->
  </div>
</header><!-- End Header