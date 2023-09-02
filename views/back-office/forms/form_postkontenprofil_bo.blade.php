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
    <a href="{{route('post-konten-profil')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
  </div>
  <h1>Kembali Ke Halaman Pengolahan Konten Profil PPID</h1> 
</div>

<div class="section-body">
  <h2 class="section-title">Buat Post Konten Profil PPID</h2>
  <p class="section-lead">
    On this page you can create a new post and fill in all fields.
  </p>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Form Post Konten Profil PPID</h4>
        </div>

          @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
            </div>
          @endif 
        <div class="card-body">
          <form id="form-post-content" action="{{ route('post-konten-profil') }}" method="POST" enctype="multipart/form-data">
            @csrf          
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}">
                <input id="created_by" type="hidden" class="form-control" name="created_by" value="{{ Auth::user()->id }}">
                @error('judul')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Untuk Menu</label>
              <div class="col-sm-12 col-md-7">
                <select class="form-control selectric @error('menu') is-invalid @enderror" id="menu" name="menu">
                  <option value="Tentang">Tentang</option>
                  <option value="Tugas dan Fungsi">Tugas dan Fungsi</option>
                  <option value="Visi dan Misi">Visi dan Misi</option>
                  <option value="Struktur">Struktur</option>
                  <option value="Regulasi">Regulasi</option>
                  <option value="Maklumat Pelayanan">Maklumat Pelayanan</option>
                  <option value="Mekanisme Permohonan">Mekanisme Permohonan</option>
                  <option value="Mekanisme Keberatan">Mekanisme Keberatan</option>
                  <option value="Mekanisme Sengketa">Mekanisme Sengketa</option>
                  <option value="Waktu Pelayanan">Waktu Pelayanan</option>
                  <option value="Standar Biaya">Standar Biaya</option>
                  <option value="Kebijakan Privasi">Kebijakan Privasi</option>
                </select>
                @error('menu')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>            
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Isi Konten</label>
              <div class="col-sm-12 col-md-7">
                <textarea class="summernote-simple @error('isi_konten') is-invalid @enderror" rows="5" cols="90" id="isi_konten" name="isi_konten">{{ old('isi_konten') }}</textarea>
                @error('isi_konten')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>      
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Post</label>
              <div class="col-sm-12 col-md-7 ">
                <label class="custom-switch mt-2">
                  <input type="checkbox" name="status_post_checkbox" id="status_post_checkbox" class="custom-switch-input @error('status_post_checkbox') is-invalid @enderror">
                  <input type="hidden" name="status_post" id="status_post" class="status_post" value="pending">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Saya ingin mempublikasikan konten ini.</span>
                </label>
                  @error('status_post_checkbox')
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

@push('app-script')
<script>
  var options = {
    filebrowserImageBrowseUrl: '/back-office/ppid-filemanager?type=Images',
    filebrowserImageUploadUrl: '/back-office/ppid-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/back-office/ppid-filemanager?type=Files',
    filebrowserUploadUrl: '/back-office/ppid-filemanager/upload?type=Files&_token='
  };
</script>

<script>
CKEDITOR.replace( 'isi_konten', options );

$(document).ready(function() {
  $('#status_post_checkbox').click(function() {
    if($(this).prop("checked") == true){
        $('#status_post').val("publish");
    }
    else if($(this).prop("checked") == false){
        $('#status_post').val("pending");
    }    
  });
});  
</script>
@endpush


