@extends('front-office.layouts.master')

@section('title', 'Halaman Reset Password')

@section('navbar')
    <x-navbar-auth-front-office/>
@endsection

@section('topsection')
  <x-header-home-area/>
@endsection

@section('mainsection')

    <!-- ======= Services Section ======= -->
    <div id="services" class="services-area area-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Reset Password') }}</div>
                        @include('sweetalert::alert')

                        <div class="card-body">
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                        <!-- @error('email') -->
                                            <!-- <span class="invalid-feedback" role="alert"> -->
                                                <!-- <strong>{{ $message }}</strong> -->
                                            <!-- </span> -->
                                        <!-- @enderror -->
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror password_onfocus" name="password" required autocomplete="new-password" data-toggle="popover" data-html="true" data-placement="top" data-content="&#128204; <b>Panjang password minimal 10 karakter.</b> <br> &#128204; <b>Password harus berisi minimal 1 huruf besar/kapital dan 1 huruf kecil.</b> <br> &#128204; <b>Password minimal berisi 1 simbol.</b> <br> &#128204; <b>Password minimal berisi 1 angka.</b>">

                                    </div>
                                    <div class="col-md-12 mt-4">
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
                                            @if($error == "passwords.token")
                                                <div class="alert alert-danger alert-block small mt-2 text-center">
                                                    <strong>Anda tidak bisa melakukan reset password dengan link ini. Token reset password sudah kadaluarsa/expire.</strong>
                                                </div>                                                   
                                            @endif                                                                                           
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>                                 

                                <div class="form-group row">
                                    <label for="captcha" class="col-md-4 col-form-label text-md-right">{{ __('Captcha') }}</label>
                                    <div class="col-md-6 captcha-img mb-3" id="reload-captcha">
                                      <span>{!! Captcha::img('flat') !!}</span>
                                        <button type="button" class="btn btn-danger tooltip-custom reload" id="btn-reload" title="reload captcha">&#x21bb;</button>                                        
                                        <input id="captcha" type="text" class="form-control  @error('captcha') is-invalid @enderror mt-2 mb-3" placeholder="Enter Captcha" name="captcha" autocomplete="off">
                                    </div>
                                    <div class="col-md-12">
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
                                </div>                                                               

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Services Section -->

@endsection

@push('app-script')
<script>

$(document).ready(function() {
    $('.password_onfocus').popover({
        trigger: 'focus'
    }).on('shown.bs.popover', function() {
        $('body .popover').css({ 'max-width': '600px' });
    }); 

    $('#btn-reload').click(function () {
        $.ajax({
            type: 'GET',
            url: '{{ route("reload-captcha") }}',
            success: function (data) {
                // $('.captcha-img span img').attr('src','/captcha/flat?'+Math.random());
                $(".captcha-img span").html(data.captcha);
            },
            error: function(){
                $(".captcha-img span").html('Tidak bisa reload captcha, Token reset password anda telah expire.');
            }
        });
    }); 

    $('.tooltip-custom').tooltip();     
        
});
</script>
@endpush
