@extends('front-office.layouts.master')

@section('title', 'Halaman Verifikasi E-mail')

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
              <h2>Verifikasi Email</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-8 col-md-8 col-lg-8 mx-auto">
            @if (session('resent'))
              <div class="alert alert-success" role="alert">
                  {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
              </div>
            @endif
            <div class="alert alert-secondary" role="alert">
              <h5 class="alert-heading text-center">Data anda sudah tersimpan, silahkan cek kotak masuk email anda untuk tautan verifikasi akun.</h5>
              <p></p>
              <hr>
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <p class="mb-0 text-center">Jika tidak menerima email verifikasi, silahkan klik
                          <span><button type="submit" class="btn btn-link text-primary p-0 m-0 align-baseline">{{ __('disini') }}</button>.</span>
                    </p>
                </form>               
            </div>
          </div>
        </div>
      </div>
    </div><!-- End About Section -->    

@endsection
