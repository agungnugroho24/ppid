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
    <a href="{{route('status-permohonan-adm')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
  </div>
  <h1>Edit Data Status Permohonan</h1> 
</div>

<div class="section-body">
  <h2 class="section-title">Edit Status Permohonan</h2>
  <p class="section-lead">
    On this page you can create a new post and fill in all fields.
  </p>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Form Edit Status Permohonan</h4>
        </div>

        <div class="card-body">
          <form id="form-post-content" action="{{ route('status-permohonan-adm-update',  $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf      
            @method('PUT')    
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Status</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" id="nama_status" name="nama_status" class="form-control @error('nama_status') is-invalid @enderror" value="{{ old('nama_status' , $data->nama_status) }}">
                @error('nama_status')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Status(Singkat)</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" id="nama_status_singkat" name="nama_status_singkat" class="form-control @error('nama_status_singkat') is-invalid @enderror" value="{{ old('nama_status_singkat', $data->nama_status_singkat)  }}" readonly>
                @error('nama_status_singkat')
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


