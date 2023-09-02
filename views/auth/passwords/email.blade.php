@extends('front-office.layouts.master')

@section('title', 'Halaman Kirim Email Reset Password')

@section('navbar')
  <x-navbar-auth-front-office/>
@endsection

@section('topsection')
  <x-header-home-area/>
@endsection


@section('mainsection')
    <!-- ======= About Section ======= -->
    <div class="skill-bg area-padding-2">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="section-headline text-center">
              <h2>Lupa Password</h2>
            </div>
          </div>
        </div>
        <div class="row">
          @include('sweetalert::alert')

          <div class="col-sm-8 col-md-6 col-lg-4 mx-auto">
            @if (session('success'))
              <div class="alert alert-success" role="alert">
                  {{ __('Tautan reset password berhasil dikirim.!') }}
              </div>
            @endif  

            @error('email')
              <div class="alert alert-danger" role="alert">
                  {{ __('Anda tidak terdaftar pada sistem kami, silahkan registrasi terlebih dahulu.!') }}
              </div>
            @enderror                      
            <div class="card card-signin my-5">
              <div class="card-body">
                <div class="text-center">
                  <h5><i class="fa fa-lock fa-4x"></i></h5>
                  <h4 class="text-center">Forgot Password?</h4>
                  <p>You can reset your password here.</p>
                  <div class="panel-body">
                    <form id="forgot-form" role="form" autocomplete="off" class="form" method="POST" action="{{ route('password.email') }}">
                      @csrf
                      <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroup-sizing-sm"><i class="fa fa-envelope"></i></span>
                        </div>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email address" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{ old('email') }}" required>
                      </div>
                      <div class="input-group input-group-sm mb-3" id="reload-captcha">
                        <input id="captcha" type="text" class="form-control  @error('captcha') is-invalid @enderror mt-2 mb-3" placeholder="Enter Captcha" name="captcha" autocomplete="off">
                      </div>  
                      <div class="input-group input-group-sm mb-3" id="reload-captcha">
                        <div class="col-md-12 mb-3" >
                          <span class="captcha-img">{!! Captcha::img('flat') !!}</span>
                            <button type="button" class="btn btn-danger tooltip-custom reload" id="btn-reload" title="reload captcha">&#x21bb;</button>                                        
                        </div>
                      </div>  
                      <div class="input-group input-group-sm mb-3">
                          @if ($errors->has('captcha'))
                              @if( $errors->first('captcha') == "validation.required" )
                                <div class="alert alert-danger alert-block small text-center">
                                    <strong>Captcha : Captcha tidak boleh kosong.</strong>
                                </div>
                              @endif                                

                              @if( $errors->first('captcha') == "validation.captcha" )
                                <div class="alert alert-danger alert-block small text-center">
                                    <strong>Captcha : Captcha yang ada masukkan tidak sesuai.!</strong>
                                </div>
                              @endif
                          @endif 
                      </div>                                                               
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send Password Reset Link') }}
                        </button>
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

    $('#btn-reload').click(function () {
        $.ajax({
            type: 'GET',
            url: '{{route("reload-captcha")}}',
            success: function (data) {
                // $('div.captcha-img span img').attr('src','/captcha/flat?'+Math.random());
                $("span.captcha-img").html(data.captcha);
            }
        });
    }); 

    $('.tooltip-custom').tooltip();     
        
});
</script>
@endpush

