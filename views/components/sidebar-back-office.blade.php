<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ route('back-office') }}"><span class="text-danger">Back Office</span> PPID</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ route('back-office') }}">PPID</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li><a class="nav-link" href="{{ route('back-office') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Request</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{ route('informasi-publik-bo')}}">Permintaan&nbsp;Informasi</a></li>
            <li><a class="nav-link" href="{{ route('kunjungan-tamu-bo')}}">Permohonan&nbsp;Kunjungan</a></li>
            <li><a class="nav-link" href="{{ route('pengajuan-keberatan-bo')}}">Pengajuan&nbsp;Keberatan</a></li>
          </ul>
        </li>
      @hasrole('developer|super-administrator|sekretariat')  
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Posts Content</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('post-informasi-publik')}}">Post&nbsp;Informasi&nbsp;Publik</a></li>
            <li><a class="nav-link" href="{{route('post-kunjungan-tamu')}}">Post&nbsp;Kunjungan&nbsp;Tamu</a></li>
            <li><a class="nav-link" href="{{route('post-laporan')}}">Post&nbsp;Laporan</a></li>
            <li><a class="nav-link" href="{{route('post-konten-profil')}}">Post&nbsp;Konten&nbsp;Profil</a></li>
            <li><a class="nav-link" href="{{route('post-konten-berita')}}">Post&nbsp;Konten&nbsp;Berita</a></li>
            <!-- <li><a class="nav-link" href="forms-validation.html">Validation</a></li> -->
          </ul>
        </li>
      @endhasrole 

      @hasanyrole('developer|super-administrator|sekretariat')
        <li class="menu-header">Administration</li>

        @hasrole('developer|super-administrator')
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-user-tag"></i> <span>User</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('manajemen-user-adm')}}">User</a></li>
          </ul>
        </li> 
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-tasks"></i> <span>Role&nbsp;&&nbsp;Permission</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('role-user-adm')}}">Role</a></li>
            <li><a class="nav-link" href="{{route('permission-user-adm')}}">Permission</a></li>
            <li><a class="nav-link" href="{{route('assign-role-permission-adm')}}">Assign&nbsp;Role&nbsp;&&nbsp;Permission</a></li>
          </ul>
        </li>
        @endhasrole

        @hasrole('developer|super-administrator')
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="far fa-comment-alt"></i> <span>Status</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('status-permohonan-adm')}}">Status&nbsp;Permohonan</a></li>
            <!-- <li><a class="nav-link" href="bootstrap-badge.html">Badge</a></li> -->
          </ul>
        </li>
        @endhasrole
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fab fa-wpforms"></i> <span>Forms</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('format-surat-adm')}}">Format&nbsp;Surat</a></li>
          </ul>
        </li>

        @hasrole('developer|super-administrator|sekretariat')
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-info-circle"></i> <span>Information</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('informasi-front-office-adm')}}">Informasi&nbsp;Front&nbsp;Office</a></li>
          </ul>
        </li>
        @endhasrole
        @hasrole('developer|super-administrator')
        <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-envelope"></i> <span>Email</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="{{route('kirim-email-adm')}}">Penerima&nbsp;Notifikasi</a></li>
          </ul>
        </li>              
        @endhasrole
      @endhasanyrole

<!--               <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="far fa-user"></i> <span>Auth</span></a>
          <ul class="dropdown-menu">
            <li><a href="auth-forgot-password.html">Forgot Password</a></li>
            <li><a href="auth-login.html">Login</a></li>
            <li><a class="beep beep-sidebar" href="auth-login-2.html">Login 2</a></li>
            <li><a href="auth-register.html">Register</a></li>
            <li><a href="auth-reset-password.html">Reset Password</a></li>
          </ul>
        </li> -->
<!--               <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-exclamation"></i> <span>Errors</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="errors-503.html">503</a></li>
            <li><a class="nav-link" href="errors-403.html">403</a></li>
            <li><a class="nav-link" href="errors-404.html">404</a></li>
            <li><a class="nav-link" href="errors-500.html">500</a></li>
          </ul>
        </li> -->
<!--               <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-bicycle"></i> <span>Features</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="features-activities.html">Activities</a></li>
            <li><a class="nav-link" href="features-post-create.html">Post Create</a></li>
            <li><a class="nav-link" href="features-posts.html">Posts</a></li>
            <li><a class="nav-link" href="features-profile.html">Profile</a></li>
            <li><a class="nav-link" href="features-settings.html">Settings</a></li>
            <li><a class="nav-link" href="features-setting-detail.html">Setting Detail</a></li>
            <li><a class="nav-link" href="features-tickets.html">Tickets</a></li>
          </ul>
        </li> -->
<!--               <li class="nav-item dropdown">
          <a href="#" class="nav-link has-dropdown"><i class="fas fa-ellipsis-h"></i> <span>Utilities</span></a>
          <ul class="dropdown-menu">
            <li><a href="utilities-contact.html">Contact</a></li>
            <li><a class="nav-link" href="utilities-invoice.html">Invoice</a></li>
            <li><a href="utilities-subscribe.html">Subscribe</a></li>
          </ul>
        </li> -->
        <!-- <li><a class="nav-link" href="credits.html"><i class="fas fa-pencil-ruler"></i> <span>Credits</span></a></li> -->
      </ul>

      <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
        <a href="{{ route('front-office') }}" class="btn btn-primary btn-lg btn-block btn-icon-split">
          <i class="fas fa-rocket"></i> Front Office
        </a>
      </div>
  </aside>
</div> 