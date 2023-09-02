@extends('front-office.layouts.master')

@section('title', 'Informasi Serta Merta PPID Kementerian PPN/Bappenas')

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
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="section-headline text-center">
              <h2>Informasi Serta Merta</h2>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 col-list">
              @isset($data)
              @foreach($data as $row)  
              <div class="card mb-4 card-ppid-custom">
                    <div class="card-body">
                      <h5 class="card-title mb-3">
                        <b> 
                          {{ $row->judul }}
                        </b>
                      </h5>

                      {!! $row->konten_pendek !!}

                      @php
                        $route = route('show-informasisertamerta', $row->uuid_code);
                      @endphp
                      <x-btn-baca-lebih-lanjut :route="$route" target="_blank" classes="btn btn-secondary float-right btn-read-custom"/>                      

                      <!-- <a href="{{ route('show-informasisertamerta', $row->uuid_code) }}" target="_blank" class="btn btn-dark float-right btn-read-custom" style="padding: 6px 18px 6px 18px;font-size: 14px;border-radius:20px;">Baca lebih lanjut &nbsp;<img style="padding-bottom: 3px;" width="19" src="{{ asset('img/icon/fast-forward.png') }}"></a> -->
                    </div>
              </div>
              @endforeach
              @endisset  
            </div>

            @isset($data)
              <div style="margin-top: 20px;">
                {{ $data->links() }}
              </div>
            @endisset            
        </div>
      </div>
    </div>
    <!-- End About Section -->
@endsection

@push('app-script')
<script src="{{ asset('assets/front-office/vendor/jquery/jquery-2.1.1.min.js')}}"></script>
<script src="{{ asset('assets/front-office/vendor/readmore/readmore.js')}}"></script>

<script>
$( document ).ready(function() {
  $('.card-ppid-custom').mouseover(function(e){
    $(this).addClass('card-custom-fly');
  });

  $('.card-ppid-custom').mouseleave(function(e){
    $(this).removeClass('card-custom-fly');
  });  

}); 
</script>
@endpush