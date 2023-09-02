<div>
  <nav class="nav-menu d-none d-lg-block">
    <ul>
      <li class="active"><a href="#header">Home</a></li>
      <li><a href="#about">About</a></li>
      <!-- <li><a href="#services">Services</a></li> -->
      <!-- <li><a href="#team">Team</a></li> -->
      <li><a href="#portfolio">Portfolio</a></li>
      <li><a href="#blog">Blog</a></li>
      <li class="drop-down"><a href="">Drop Down</a>
        <ul>
          <li><a href="#">Drop Down 1</a></li>
          <li class="drop-down"><a href="#">Drop Down 2</a>
            <ul>
              <li><a href="#">Deep Drop Down 1</a></li>
              <li><a href="#">Deep Drop Down 2</a></li>
              <li><a href="#">Deep Drop Down 3</a></li>
              <li><a href="#">Deep Drop Down 4</a></li>
              <li><a href="#">Deep Drop Down 5</a></li>
            </ul>
          </li>
          <li><a href="#">Drop Down 3</a></li>
          <li><a href="#">Drop Down 4</a></li>
          <li><a href="#">Drop Down 5</a></li>
        </ul>
      </li>
      <li><a href="#contact">Contact</a></li>
      <li class="drop-down"><a href="">My Page</a>
        <ul>
          @if (Route::has('login'))
            @auth
              <li><a href="{{ route('home') }}">Dashboard</a></li>
              <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>                  
            @else
              <li><a href="{{ route('login') }}">Log in</a></li>

              @if (Route::has('register'))
                <li><a href="{{ route('register') }}">Register</a></li>
              @endif
            @endauth
          @endif 
        </ul>
      </li>                  
    </ul>
  </nav><!-- .nav-menu -->
</div>