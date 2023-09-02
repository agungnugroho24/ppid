<style>
  .nivo-directionNav a {
      top: 60%;
  }
</style>
<!-- ======= Slider Section ======= -->
<div id="desktop" class="slider-area">
  <div class="bend niceties preview-2">
    <div id="ensign-nivoslider" class="slides">
@isset($databerita)
@foreach($databerita as $key => $row)  
      <img src="{{ asset('img/slider/banner6.jpg') }}" alt="" title="#slider-direction-{{$key+1}}" />
@endforeach
@endisset        
    </div>

@isset($databerita)
@foreach($databerita as $key => $row)
    <!-- direction 1 -->
    <div id="slider-direction-{{$key+1}}" class="slider-direction slider-one">
      <div class="container" style="margin-top: -7.5%;">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="slider-content">
              <section>
                <div class="py-3">
                  <div class="card" style="background: rgba(0, 0, 0, 0.3);border: 0px;">
                    <div class="row ">
                      <div class="col-md-4">
                          @isset($row->thumbnail)
                            <img src="{{ asset('storage/post_berita/'.$row->thumbnail) }}" style="left: 4%;height:100%;width:100%;">
                          @endisset
                          @empty($row->thumbnail)
                            <img src="{{ asset('img/news.png') }}" style="left: 4%;height:100%;width:100%;">
                          @endempty
                        </div>
                        <div class="col-md-8 mt-2 mb-2">
                          <div class="card-block mt-2 mb-2 mr-1 ml-1">
                            <h5 class="card-title" style="color: #ffffff;font-weight:800;">{{ $row->judul }}</h5>
                            <div class="slide-berita text-justify mr-2 ml-2">
                              {!! $row->konten_pendek !!}
                            </div>
                          </div>
                          <a class="" href="{{ route('show-berita', $row->uuid_code) }}" target="_blank">
                              <button class="btn btn-sm btn-primary rounded-pill text-center">
                                Lihat Berita
                              </button>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
@endforeach
@endisset
  </div>
</div><!-- End Slider -->

<div id="gadget" class="carousel slide slider-area" data-ride="carousel" style="width: 100%;background-color:#a2a2a2;">
<!-- Indicators -->
<ul class="carousel-indicators">
  @isset($databerita)
  @foreach($databerita as $key => $row) 
  @php
    if($key == 0):
      $class = 'active';
    else:
      $class = '';
    endif;
  @endphp   
  <li data-target="#gadget" data-slide-to="{{$key}}" class="{{ $class }}"></li>
  @endforeach
  @endisset    
</ul>

<!-- The slideshow -->
<div class="carousel-inner">
@isset($databerita)
@foreach($databerita as $keys => $row)
@php
  if($keys == 0):
    $classes = 'carousel-item active';
  else:
    $classes = 'carousel-item';
  endif;
@endphp     
<div class="{{ $classes }}">
  <div class="card" style="width: 100%;background-color:#a2a2a2;">

    @isset($row->thumbnail)
      <img src="{{ asset('storage/post_berita/'.$row->thumbnail) }}" style="left: 4%;height:100%;width:100%;" class="card-img-top">
    @endisset
    @empty($row->thumbnail)
      <img src="{{ asset('img/news.png') }}" style="left: 4%;height:100%;width:100%;" class="card-img-top">
    @endempty

    <div class="card-body" style="color:#ffffff;">
      <div class="card-text slide-berita">
        {{-- {!! $row->konten_pendek !!} --}}
        <h4 class="text-light">{!! $row->judul !!}</h4>
      </div>
      <a href="{{ route('show-berita', $row->uuid_code) }}" class="btn btn-sm btn-primary" target="_blank">Lihat berita</a>
    </div>
  </div>
</div>
@endforeach
@endisset  
</div>

<!-- Left and right controls -->
<a class="carousel-control-prev" href="#gadget" data-slide="prev">
  <span class="carousel-control-prev-icon"></span>
</a>
<a class="carousel-control-next" href="#gadget" data-slide="next">
  <span class="carousel-control-next-icon"></span>
</a>

</div>