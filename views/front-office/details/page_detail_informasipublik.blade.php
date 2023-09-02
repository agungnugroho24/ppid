@extends('front-office.layouts.master')

@section('title')
  {{ $data['judul'] }}
@endsection

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
        <!-- Start single blog -->
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <!-- single-blog start -->
              <article class="blog-post-wrapper">
                <div class="post-information">
                  <h2>{{ Str::ucfirst($data['judul']) }}</h2>
                  <div class="entry-meta">
                    <span class="author-meta"><i class="fa fa-user"></i> {{ Str::lower($data['penulis']) }}</span>
                    <span><i class="fa fa-clock-o"></i> {{ Str::lower($data['tanggalpost']) }}</span>
                    <span class="tag-meta">
                      <i class="fa fa-folder-o"></i>
                      <a href="{{ $data['url'] }}" target="_blank">{{ 'informasi '.Str::lower($data['kategori']) }}</a>
                    </span>
                  </div>
                  <div class="entry-content">
                    {!! $data['isi_konten'] !!}
                  </div>
                </div>
              </article>
              <div class="clear"></div>
              <!-- single-blog end -->
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
 //
});
</script>
@endpush