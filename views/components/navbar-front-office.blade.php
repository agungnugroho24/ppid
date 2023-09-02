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
				{{-- <li class="nav-item">
			        <p class="mt-2 mr-2" id="search-icon" style="color:#ffffff;cursor:pointer;">Search <i class="fa fa-search" style=""></i></p>
			        <div id="search-menu">
                        <div id="wrapper" class="wrapper">
                            <form id="form1">
                            <input id="search" class="search-input" type="text" placeholder="Ketik yang ingin dicari lalu tekan enter atau icon loop"/>
                            <button id="btn-search-icon-after" type="submit"><i class="fa fa-search" onclick="searchToggleMobile(this, event);"></i></button>
                            </form>
                        </div>
                        <br>
                        <div class="text-center">
                            <button id="close" class="btn btn-sm btn-danger"><b class="ml-1 mr-1 mb-2 mt-2"><i class="fa fa-times"></i> Tutup</b></button>
                        </div>
                    </div>
			    </li> --}}
				<li class="active"><a href="{{ route('front-office') }}">Beranda</a></li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownProfil" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Profil
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownProfil">
						<a class="dropdown-item" href="{{ route('ppid-tentang') }}" style="color: #165a64;">Tentang</a>
						<a class="dropdown-item" href="{{ route('ppid-tugasfungsi') }}" style="color: #165a64;">Tugas dan Fungsi</a>
						<a class="dropdown-item" href="{{ route('ppid-visimisi') }}" style="color: #165a64;">Visi dan Misi</a>
						<a class="dropdown-item" href="{{ route('ppid-struktur') }}" style="color: #165a64;">Struktur</a>
						<a class="dropdown-item" href="{{ route('ppid-regulasi') }}" style="color: #165a64;">Regulasi</a>
						<a class="nav-link dropdown-submenu dropdown-toggle" href="javascript:void(0);" data-toggle="dropdown" style="color: #165a64;">Standar Layanan</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="{{ route('ppid-maklumatpelayanan') }}" style="color: #165a64;">Maklumat Pelayanan</a>
							<a class="dropdown-item" href="{{ route('ppid-mekanismepermohonan') }}" style="color: #165a64;">Mekanisme Permohonan</a>
							<a class="dropdown-item" href="{{ route('ppid-mekanismekeberatan') }}" style="color: #165a64;">Mekanisme Keberatan</a>
							<a class="dropdown-item" href="{{ route('ppid-mekanismesengketa') }}" style="color: #165a64;">Mekanisme Sengketa</a>
							<a class="dropdown-item" href="{{ route('ppid-waktupelayanan') }}" style="color: #165a64;">Waktu Pelayanan</a>
							<a class="dropdown-item" href="{{ route('ppid-standarbiaya') }}" style="color: #165a64;">Standar Biaya</a>
							<a class="dropdown-item" href="{{ route('ppid-kebijakanprivasi') }}" style="color: #165a64;">Kebijakan Privasi</a>
						</div>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPublik" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Informasi Publik
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownPublik">
						<a class="dropdown-item" href="{{ route('ppid-informasiberkala') }}" style="color: #165a64;">Informasi Berkala</a>
						<a class="dropdown-item" href="{{ route('ppid-informasisertamerta') }}" style="color: #165a64;">Informasi Serta Merta</a>
						<a class="dropdown-item" href="{{ route('ppid-informasisetiapsaat') }}" style="color: #165a64;">Informasi Setiap Saat</a>						
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownTamu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Kunjungan tamu
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownTamu">
						<a class="dropdown-item" href="{{ route('ppid-sop') }}" style="color: #165a64;">SOP</a>
						<a class="dropdown-item" href="{{ route('ppid-tatacara') }}" style="color: #165a64;">Tata Cara</a>					
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownLaporan" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Laporan
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownLaporan">
						<a class="dropdown-item" href="{{ route('ppid-aksesinfopublik') }}" style="color: #165a64;">Akses Informasi Publik</a>
						<a class="dropdown-item" href="{{ route('ppid-layananinfopublik') }}" style="color: #165a64;">Layanan Informasi Publik</a>
						<a class="dropdown-item" href="{{ route('ppid-surveilayananinfopublik') }}" style="color: #165a64;">Survei Layanan Informasi Publik</a>
						<a class="dropdown-item" href="{{ route('ppid-statkunjungantamu') }}" style="color: #165a64;">Statistik Kunjungan Tamu</a>
					</div>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMyPage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						My Page
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdownMyPage">
			          @if (Route::has('login'))
			            @auth
						  <a class="dropdown-item" href="{{ route('home') }}" style="color: #165a64;">Dashboard</a>
			              <a class="dropdown-item" href="{{ route('logout') }}" style="color: #165a64;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
			                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
			                    @csrf
			                </form>                  
			            @else
				            <a class="dropdown-item" href="{{ route('login') }}" style="color: #165a64;">Log in</a>

			              @if (Route::has('register'))
							<a class="dropdown-item" href="{{ route('register') }}" style="color: #165a64;">Register</a>
			              @endif
			            @endauth
			          @endif						
						
					</div>
				</li>

			</ul>
		</nav><!-- .nav-menu -->
				
	</div>
	{{-- <div style="position:sticky;">
		<div id="search-wrapper" class="search-wrapper">
		    <div class="input-holder">
		        <input type="text" class="search-input" placeholder="Type to search" />
		        <button id="btn-search-icon-before" class="search-icon" onclick="searchToggle(this, event);"><i id="i-icon" style="font-size:1.8em;font-weight:bold;color:red;" class="fas fa-search"></i></button>
		        <button id="btn-search-icon-after" class="search-icon"><span></span></button>
		    </div>
		    <span id="btn-search-close" title="close search" class="close" onclick="searchToggle(this, event);"></span>
		</div>											
	</div>	 --}}
	<div class="text-center">
	    <img width="250" height="188" id="loader" src="{{asset('img/loading-6.gif')}}" style="display:none;margin-top:12%;z-index: 1;margin-left: auto;margin-right: auto;">
	</div>
</header>
<!-- End Header -->


<!-- ======= Header ======= -->
<header id="header" class="fixed-top mobile">
	<div class="container d-flex">
		<div class="logo mr-auto">
			<h1 class="text-light"><a href="{{route('front-office')}}"><span>e</span>-PPID</a></h1>
			<!-- Uncomment below if you prefer to use an image logo -->
			<!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
		</div>
		<nav class="nav-menu d-none d-lg-block">
			<ul>
<!-- 				<li>
					<form>
						<input id="mobile" type="text" name="search" placeholder="Search..">
					</form>
				</li> -->
				<li class="active"><a href="{{ route('front-office') }}">Beranda</a></li>
				<li class="drop-down"><a href="#">Profil</a>
					<ul>
						<li><a href="{{ route('ppid-tentang') }}">Tentang</a></li>
						<li><a href="{{ route('ppid-tugasfungsi') }}">Tugas dan Fungsi</a></li>
						<li><a href="{{ route('ppid-visimisi') }}">Visi dan Misi</a></li>
						<li><a href="{{ route('ppid-struktur') }}">Struktur</a></li>
						<li><a href="{{ route('ppid-regulasi') }}">Regulasi</a></li>
						<li><a href="{{ route('ppid-maklumatpelayanan') }}">Maklumat Pelayanan</a></li>
						<li><a href="{{ route('ppid-mekanismepermohonan') }}">Mekanisme Permohonan</a></li>
						<li><a href="{{ route('ppid-mekanismekeberatan') }}">Mekanisme Keberatan</a></li>
						<li><a href="{{ route('ppid-mekanismesengketa') }}">Mekanisme Sengketa</a></li>
						<li><a href="{{ route('ppid-waktupelayanan') }}">Waktu Pelayanan</a></li>
						<li><a href="{{ route('ppid-standarbiaya') }}">Standar Biaya</a></li>
						<li><a href="{{ route('ppid-kebijakanprivasi') }}">Kebijakan Privasi</a></li>
					</ul>
				</li>
				<li class="drop-down"><a href="#">Informasi Publik</a>
					<ul>
						<li><a href="{{ route('ppid-informasiberkala') }}">Informasi Berkala</a></li>
						<li><a href="{{ route('ppid-informasisertamerta') }}">Informasi Serta Merta</a></li>
						<li><a href="{{ route('ppid-informasisetiapsaat') }}">Informasi Setiap Saat</a></li>
					</ul>
				</li>
				<li class="drop-down"><a href="#">Kunjungan Tamu</a>
					<ul>
						<li><a href="{{ route('ppid-sop') }}">SOP</a></li>
						<li><a href="{{ route('ppid-tatacara') }}">Tata Cara</a></li>
					</ul>
				</li>
				<li class="drop-down"><a href="#">Laporan</a>
					<ul>
						<li><a href="{{ route('ppid-aksesinfopublik') }}">Akses Informasi Publik</a></li>
						<li><a href="{{ route('ppid-layananinfopublik') }}">Layanan Informasi publik</a></li>
						<li><a href="{{ route('ppid-surveilayananinfopublik') }}">Survei Layanan Informasi Publik</a></li>
						<li><a href="{{ route('ppid-statkunjungantamu') }}">Statistik Kunjungan Tamu</a><li>	
					</ul>
				</li>
				<li class="drop-down"><a href="#">My Page</a>
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
	<div style="position:sticky;">
		<div id="search-wrapper" class="search-wrapper-mobile">
		    <div class="input-holder-mobile">
		        <input type="text" class="search-input-mobile" placeholder="Type to search" />
		        <button id="btn-search-icon-before-mobile" class="search-icon-mobile" onclick="searchToggleMobile(this, event);"><i id="i-icon" style="font-size:1.8em;font-weight:bold;color:red;" class="fas fa-search"></i></button>
		        <button id="btn-search-icon-after-mobile" class="search-icon-mobile"><span></span></button>
		    </div>
		    <span id="btn-search-close-mobile" class="close-mobile" onclick="searchToggleMobile(this, event);"></span>
		</div>											
	</div>	
	<div class="text-center">
	    <img width="200" id="loader-mobile" src="{{asset('img/loading-6.gif')}}" style="display:none;margin-top:2%;">
	</div>	
</header><!-- End Header