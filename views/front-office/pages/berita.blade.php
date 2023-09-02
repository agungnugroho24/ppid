<!-- Menghubungkan dengan view template master -->
@extends('front-office.layouts.master')

@section('title', 'Berita PPID Kementerian PPN/Bappenas')

@section('navbar')
  <x-navbar-front-office/>
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
              <h2>Berita</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-lg-12">
            @empty($data)
            <img class="float-left" src="{{ asset('img/news-lg.png') }}" alt="" width="400" height="300" style="margin-right: 1%;">
            @endempty
            @isset($data)
            <img class="float-left" src="{{ $data['thumbnail'] }}" alt="" width="400" height="300" style="margin-right: 1%;">
            <span class=""> 
              <h3 class="text-center">{{ $data['judul'] }}</h3>             
              {!! $data['isi_konten'] !!} 
            </span>
            @endisset
          </div>
        </div>
      </div>
    </div><!-- End About Section -->

 @endsection