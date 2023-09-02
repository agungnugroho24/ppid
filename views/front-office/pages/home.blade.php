@extends('front-office.layouts.master')

@section('title', 'My Page')

@section('navbar')
  <x-navbar-home/>
@endsection

@section('topsection')
  <x-header-home-area/>
@endsection

@section('mainsection')

    <!-- ======= About Section ======= -->
    @include('sweetalert::alert')
    <div id="about" class="about-area area-padding">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="section-headline text-center">
              <h2>Dashboard</h2>
              {{-- Auth::user()->is_active --}}
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="section-headline text-center">
              <p style="font-family: 'Trocchi', serif; font-size: 45px; font-weight: bold; line-height: 48px;">Selamat datang di web PPID Bappenas <?php echo date('Y') ?></p>
            </div>
          </div>
        </div>
      </div>
    </div><!-- End About Section -->

@endsection

<!-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection -->