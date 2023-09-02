@extends('front-office.layouts.master')

@section('title', 'Informasi Berkala PPID Kementerian PPN/Bappenas')

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
              <h2>Informasi Berkala</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-pane">
            <div class="accordion" id="accordionInfoPublik">
              @isset($data)
              @foreach($data as $key => $row)
              <div class="card mb-2 rounded-lg">
                <div class="card-header" id="heading-1" >
                    <h2 class="mb-0">
                      <button class="btn btn-sm btn-block btn-coll text-left collapsed" type="button" data-toggle="collapse" data-target="#collapse-{{$key+1}}" aria-expanded="true" aria-controls="collapse-1" style="font-weight: 500;">
                          {{ $row->judul }}
                      </button>
                    </h2>
                </div>
                <div id="collapse-{{$key+1}}" class="collapse" aria-labelledby="heading-1" data-parent="#accordionInfoPublik">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-12">
                          {!! $row->konten_pendek !!}
                          <div class="mt-3">
                            @php
                              $route = route('show-informasiberkala', $row->uuid_code);
                            @endphp
                            <x-btn-baca-lebih-lanjut :route="$route" target="_blank" classes="btn btn-sm btn-outline-secondary float-right"/>

                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              @endforeach
              @endisset

              @isset($data)
                <div class="mt-4">
                  {{ $data->links() }}
                </div>
              @endisset

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End About Section -->
@endsection

@push('app-script')
<script>
$(document).ready( function() {
  $(".gallery").flipping_gallery({
    enableScroll: true,
    autoplay: 5000
  });
  
  $(".next").click(function() {
    $(".gallery").flipForward();
    return false;
  });
  $(".prev").click(function() {
    $(".gallery").flipBackward();
    return false;
  });

  if (document.cookie.indexOf('visited=true') == -1){
    // load the overlay
    $('#myModal').modal({show:true});
    
    var year = 1000*60*60*24*365;
    var expires = new Date((new Date()).valueOf() + year);
    document.cookie = "visited=true;expires=" + expires.toUTCString();
  }

  $('.card').mouseover(function(e){
    $(this).addClass('card-custom');
  });

  $('.card').mouseleave(function(e){
    $(this).removeClass('card-custom');
  });  

});


</script>
@endpush