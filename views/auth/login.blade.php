@extends('front-office.layouts.master')

@section('title', 'Halaman Login')

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
              <h2>{{ __('Login') }}</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="section-headline text-justify">
              <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
                <div class="card card0 border-0">
                  <div class="row d-flex">                   
                    <div class="col-lg-6">
                        <div class="card1 pb-5 text-center">
                            <div class="row px-3 justify-content-center mt-4 mb-5"> <img src="{{ asset('img/logo-ppid.png')}}" class="image"> </div>
                        </div>
                    </div>

                    <div class="col-lg-5" style="border-left:1px solid #d3d3d3;">
                        <div class="card2 card border-0 px-4 py-5">
                            @if ($errors->has('email'))
                                <div class="alert alert-danger alert-block small mb-2">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif  

                            @if ($errors->has('captcha'))
                                @if( $errors->first('captcha') == "validation.required" )
                                  <div class="alert alert-danger alert-block small">
                                      <strong>Captcha : Captcha tidak boleh kosong.</strong>
                                  </div>
                                @endif                                

                                @if( $errors->first('captcha') == "validation.captcha" )
                                  <div class="alert alert-danger alert-block small">
                                      <strong>Captcha : Captcha yang ada masukkan tidak sesuai.!</strong>
                                  </div>
                                @endif
                            @endif                             
                                                      
                            <form method="POST" action="{{ route('login') }}">
                              @csrf
                                <div class="row px-3"> 
                                  <label class="mb-1">
                                        <h6 class="mb-0 text-sm">{{ __('E-Mail') }}</h6>
                                  </label> 
                                  <input class="input-login mb-4 @error('email') is-invalid @enderror" type="text" name="email" id="email" placeholder="Enter a valid email address" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                <div class="row px-3"> 
                                  <label class="mb-1">
                                        <h6 class="mb-0 text-sm">{{ __('Password') }}</h6>
                                  </label> 
                                  <input type="password" class="input-login @error('password') is-invalid @enderror mb-4" id="password" name="password" placeholder="Enter password" required>
                                  @error('password')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror                                    
                                </div>
                                <div class="row px-3 mb-3"> 
                                  <div id="reload-captcha"> 
                                    <label class="mb-1">
                                          <h6 class="mb-1 text-sm">{{ __('Captcha') }}</h6>
                                          <span class="captcha">{!! captcha_img('flat') !!}</span>
                                              <button type="button" class="btn btn-danger tooltip-custom reload" id="reload" title="reload captcha">
                                              &#x21bb;
                                              </button>                                        
                                    </label> 
                                  </div>
                                  <input id="captcha" type="text" class="form-control  @error('captcha') is-invalid @enderror" placeholder="Enter Captcha" name="captcha" autocomplete="off">                                   
                                </div>                                
                                <div class="row px-3 mb-4">
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input id="remember" type="checkbox" name="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }}>
                                        <label for="remember" class="custom-control-label text-sm">{{ __('Ingat saya') }}</label>
                                    </div>
                                </div>
                                <div class="row mb-3 px-3">
                                    <button type="submit" class="btn btn-sm btn-primary text-center" style="margin-right: 2%;">{{ __('Login') }}</button>
                                </div>
                            </form>
                                <div class="row mb-1 px-3">
                                  @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"><small class="font-weight-bold">{{ __('Lupa password?') }}</small></a>
                                  @endif
                                </div>
                                <div class="row mb-3 px-3"> 
                                  <small class="font-weight-bold">Belum terdaftar? <a href="{{ route('register') }}" class="text-danger ">Register</a></small>
                                </div>
                                <div class="row mb-1 px-3"> 
                                  <a style="font-size:14px;" href="{{ url('/login-sso') }}" class="font-weight-bold text-primary"><span><img width="52" src="{{ asset('img/icon/password.png') }}"></span> Single Sign-On Bappenas</a>
                                </div>

                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- End About Section -->

@endsection

@push('app-script')
<script>
$(document).ready(function() {
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
