@extends('back-office.layouts.master')

@section('title')
 {{ $title }}
@overwrite

@push('app-styles')
  <x-css-back-office/>
@endpush

@section('content')
<div class="section-header">
  <div class="section-header-back">
    <a href="{{route('post-content')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
  </div>
  <h1>Edit Data Post Content</h1> 
  <!-- <div class="section-header-breadcrumb"> -->
    <!-- <div class="breadcrumb-item active"><a href="#">Dashboard</a></div> -->
    <!-- <div class="breadcrumb-item"><a href="#">Modules</a></div> -->
    <!-- <div class="breadcrumb-item">DataTables</div> -->
  <!-- </div> -->
</div>

<div class="section-body">
  <h2 class="section-title">Edit Post Content</h2>
  <p class="section-lead">
    On this page you can create a new post and fill in all fields.
  </p>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Form Edit Post Content</h4>
        </div>
          @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong>{{ $message }}</strong>
            </div>
          @endif

          @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
            </div>
          @endif          
        <div class="card-body">
          <form id="form-post-content" action="{{ route('post-content-update',  $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf          
            @method('PUT')          
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $data->judul) }}">
                <input id="updated_by" type="hidden" class="form-control" name="updated_by" value="{{ Auth::user()->id }}">
                @error('judul')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
              <div class="col-sm-12 col-md-7">
                <select class="form-control selectric @error('kategori') is-invalid @enderror" id="kategori" name="kategori">
                  <option value="{{ old('kategori', 'berkala') }}" @if (old('kategori') == 'berkala' || $data->kategori == 'berkala') selected="selected" @endif>Berkala</option>
                  <option value="{{ old('kategori', 'serta merta') }}" @if (old('kategori') == 'serta merta' || $data->kategori == 'serta merta') selected="selected" @endif>Serta Merta</option>
                  <option value="{{ old('kategori', 'setiap saat') }}" @if (old('kategori') == 'setiap saat' || $data->kategori == 'setiap saat') selected="selected" @endif>Setiap Saat</option>
                </select>
                @error('kategori')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Konten</label>
              <div class="col-sm-12 col-md-7">
                <textarea class="summernote-simple @error('konten') is-invalid @enderror" rows="5" cols="90" id="konten" name="konten">{{ old('konten', $data->konten) }}</textarea>
                @error('konten')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Post</label>
              <div class="col-sm-12 col-md-7">
                <select class="form-control selectric @error('status_post') is-invalid @enderror" id="status_post" name="status_post">
                  <option value="{{ old('status_post', 'pending') }}" @if (old('status_post') == 'pending' || $data->status_post == 'pending') selected="selected" @endif>Pending</option>
                  <option value="{{ old('status_post', 'publish') }}" @if (old('status_post') == 'publish' || $data->status_post == 'publish') selected="selected" @endif>Publish</option>
                  <option value="{{ old('status_post', 'draft') }}" @if (old('status_post') == 'draft' || $data->status_post == 'draft') selected="selected" @endif>Draft</option>
                </select>
                @error('status_post')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jenis Post</label>
              <div class="col-sm-12 col-md-7">
                <select class="form-control selectric @error('jenis_post') is-invalid @enderror" id="jenis_post" name="jenis_post">
                  <option value="{{ old('jenis_post', 'dinamis') }}" @if (old('jenis_post') == 'dinamis' || $data->jenis_post == 'dinamis') selected="selected" @endif>Dinamis</option>
                  <option value="{{ old('jenis_post', 'statis') }}" @if (old('jenis_post') == 'statis' || $data->jenis_post == 'statis') selected="selected" @endif>Statis</option>
                </select>
                @error('jenis_post')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>          
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
              <div class="col-sm-12 col-md-7">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection



