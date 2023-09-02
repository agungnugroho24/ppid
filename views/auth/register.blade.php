@extends('front-office.layouts.master')

@section('title', 'Halaman Registrasi')


@section('navbar')
  <x-navbar-auth-front-office/>
@endsection

@section('topsection')
  <x-header-home-area/>
@endsection

@section('mainsection')
    <!-- ======= About Section ======= -->
    <div id="about" class="about-area area-padding">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="section-headline text-center">
              <h2>Register</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="register">
                <div class="row">
                    <div class="col-md-3 register-left">
                        <img src="{{ asset('img/logo-ppid3.png')}}" alt=""/>
                        <p style="color: #ffffff;">Klik <a href="{{ route('login') }}"><b>Login</b></a> jika sudah terdaftar di web PPID</p>
                    </div>
                    <div class="col-md-9 register-right">
                        <div class="tab-content" id="myTabContent" style="margin-top: -10%;">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <form class="form-register"  method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row register-form">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="off" placeholder="Nama Depan *" autofocus>
                                                    
                                                </div>
<!--                                                 @error('first_name')
                                                    <span class="alert alert-danger alert-block small">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror -->
                                            </div>
                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="off" placeholder="Nama Belakang *" autofocus>
                                                    
                                                </div>
<!--                                                 @error('last_name')
                                                    <span class="alert alert-danger alert-block small">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror -->                                                
                                            </div>
                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" placeholder="Email *" autofocus>
                                                    
                                                </div>
<!--                                                 @error('email')
                                                    <span class="alert alert-danger alert-block small">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror -->                                             
                                            </div>                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <input id="nomor_ponsel" type="text" class="form-control @error('nomor_ponsel') is-invalid @enderror" name="nomor_ponsel" value="{{ old('nomor_ponsel') }}" required autocomplete="off" placeholder="No. Telepon *" autofocus>
                                                </div>
<!--                                                 @error('nomor_ponsel')
                                                    <span class="alert alert-danger alert-block small">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror  -->                                             
                                            </div>
                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror password_onfocus" name="password" value="{{ old('password') }}" required placeholder="Password *" data-toggle="popover" data-html="true" data-placement="top" data-content="&#128204; <b>Panjang password minimal 10 karakter.</b> <br> &#128204; <b>Password harus berisi minimal 1 huruf besar/kapital dan 1 huruf kecil.</b> <br> &#128204; <b>Password minimal berisi 1 simbol.</b> <br> &#128204; <b>Password minimal berisi 1 angka.</b>">
                                                    
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Konfirmasi Password *" autocomplete="off">
                                            </div>                                          
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <input id="captcha" type="text" class="form-control  @error('captcha') is-invalid @enderror" placeholder="Enter Captcha" name="captcha">
                                                </div>
<!--                                                 @error('captcha')
                                                    <span class="alert alert-danger alert-block small">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror  -->                                            
                                            </div>  
                                        </div>                                                                            
                                        <div class="col-md-6">
                                            <div class="form-group" id="reload-captcha">
                                                <div class="mb-3">
                                                    <span class="captcha">{!! captcha_img('flat') !!}</span>
                                                        <button type="button" class="btn btn-danger tooltip-custom reload" id="reload" title="reload captcha">
                                                        &#x21bb;
                                                        </button>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-md-12 mt-2">
                                            <div class="form-group text-center">
                                                <button type="submit" class="btn btn-sm btn-primary rounded-lg" style="margin-right: 2%;">Register</button>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            @error('first_name')
                                                <div class="alert alert-danger alert-block small mt-2 text-center">
                                                    <strong>Nama Depan : {{ $message }}</strong>
                                                </div>
                                            @enderror

                                            @error('last_name')
                                                <div class="alert alert-danger alert-block small mt-2 text-center">
                                                    <strong>Nama Belakang : {{ $message }}</strong>
                                                </div>
                                            @enderror 

                                            @error('email')
                                                <div class="alert alert-danger alert-block small mt-2 text-center">
                                                    <strong>Email : {{ $message }}</strong>
                                                </div>
                                            @enderror   

                                            @error('nomor_ponsel')
                                                <div class="alert alert-danger alert-block small mt-2 text-center">
                                                    <strong>Nomor Telepon : {{ $message }}</strong>
                                                </div>
                                            @enderror                                                                              
                                            @error('captcha')
                                                <div class="alert alert-danger alert-block small mt-2 text-center">
                                                    <strong>Captcha : {{ $message }}</strong>
                                                </div>
                                            @enderror                                                                                                
                                            @foreach ($errors->all() as $error)
                                                @if($error == "validation.min.string")
                                                    <div class="alert alert-danger alert-block small mt-2 text-center">
                                                        <strong>Panjang password minimal 10 karakter.</strong>
                                                    </div>
                                                @endif
                                                @if($error == "The password must contain at least one uppercase and one lowercase letter.")
                                                    <div class="alert alert-danger alert-block small mt-2 text-center">
                                                        <strong>Password harus berisi minimal 1 huruf besar/kapital dan 1 huruf kecil.</strong>
                                                    </div> 
                                                @endif
                                                @if($error == "The password must contain at least one symbol.")
                                                    <div class="alert alert-danger alert-block small mt-2 text-center">
                                                        <strong>Password minimal berisi 1 simbol.</strong>
                                                    </div>                                                   
                                                @endif
                                                @if($error == "The password must contain at least one number.")
                                                    <div class="alert alert-danger alert-block small mt-2 text-center">
                                                        <strong>Password minimal berisi 1 angka.</strong>
                                                    </div>                                                   
                                                @endif                                                
                                            @endforeach
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>                                    
            </div>
        </div>
      </div>
    </div><!-- End About Section -->

@endsection

@push('app-script')
<script>
$(document).ready(function() {
    $("form.form-register").attr('autocomplete', 'off');   

    $('.password_onfocus').popover({
        trigger: 'focus'
    }).on('shown.bs.popover', function() {
        $('body .popover').css({ 'max-width': '600px' });
    }); 

    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: '{{route("reload-captcha")}}',
            success: function (data) {
                $("#reload-captcha span.captcha").html(data.captcha);
            }
        });
    }); 

    $('.tooltip-custom').tooltip();   
        
});
</script>
@endpush