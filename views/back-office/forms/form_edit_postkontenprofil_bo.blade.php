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
  <h2 class="section-title">Edit Post Konten Profil PPID</h2>
  <p class="section-lead">
    On this page you can create a new post and fill in all fields.
  </p>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Form Edit Post Konten Profil PPID</h4>
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
          <form id="form-post-content" action="{{ route('post-konten-profil-update',  $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf          
            @method('PUT')          
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Judul</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" id="judul" name="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $data->judul) }}">
                <input id="updated_by" type="hidden" class="form-control" name="updated_by" value="{{ Auth::user()->id }}">
                <input id="published_at" type="hidden" class="form-control" name="published_at" value="{{ $data->published_at }}">
                @error('judul')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Menu</label>
              <div class="col-sm-12 col-md-7">
                <select class="form-control selectric @error('menu') is-invalid @enderror" id="menu" name="menu">

                  <option value="{{ old('menu', 'Tentang') }}" @if (old('menu') == 'Tentang' || $data->menu == 'Tentang') selected="selected" @endif>Tentang</option>

                  <option value="{{ old('menu', 'Tugas dan Fungsi') }}" @if (old('menu') == 'Tugas dan Fungsi' || $data->menu == 'Tugas dan Fungsi') selected="selected" @endif>Tugas dan Fungsi</option>

                  <option value="{{ old('menu', 'Visi dan Misi') }}" @if (old('menu') == 'Visi dan Misi' || $data->menu == 'Visi dan Misi') selected="selected" @endif>Visi dan Misi</option>

                  <option value="{{ old('menu', 'Struktur') }}" @if (old('menu') == 'Struktur' || $data->menu == 'Struktur') selected="selected" @endif>Struktur</option>

                  <option value="{{ old('menu', 'Regulasi') }}" @if (old('menu') == 'Regulasi' || $data->menu == 'Regulasi') selected="selected" @endif>Regulasi</option>

                  <option value="{{ old('menu', 'Maklumat Pelayanan') }}" @if (old('menu') == 'Maklumat Pelayanan' || $data->menu == 'Maklumat Pelayanan') selected="selected" @endif>Maklumat Pelayanan</option>

                  <option value="{{ old('menu', 'Mekanisme Permohonan') }}" @if (old('menu') == 'Mekanisme Permohonan' || $data->menu == 'Mekanisme Permohonan') selected="selected" @endif>Mekanisme Permohonan</option>

                  <option value="{{ old('menu', 'Mekanisme Keberatan') }}" @if (old('menu') == 'Mekanisme Keberatan' || $data->menu == 'Mekanisme Keberatan') selected="selected" @endif>Mekanisme Keberatan</option>

                  <option value="{{ old('menu', 'Mekanisme Sengketa') }}" @if (old('menu') == 'Mekanisme Sengketa' || $data->menu == 'Mekanisme Sengketa') selected="selected" @endif>Mekanisme Sengketa</option>

                  <option value="{{ old('menu', 'Waktu Pelayanan') }}" @if (old('menu') == 'Waktu Pelayanan' || $data->menu == 'Waktu Pelayanan') selected="selected" @endif>Waktu Pelayanan</option>

                  <option value="{{ old('menu', 'Standar Biaya') }}" @if (old('menu') == 'Standar Biaya' || $data->menu == 'Standar Biaya') selected="selected" @endif>Standar Biaya</option>
                  
                  <option value="{{ old('menu', 'Kebijakan Privasi') }}" @if (old('menu') == 'Kebijakan Privasi' || $data->menu == 'Kebijakan Privasi') selected="selected" @endif>Kebijakan Privasi</option>
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
                <textarea class="summernote-simple @error('isi_konten') is-invalid @enderror" rows="5" cols="90" id="isi_konten" name="isi_konten">{{ old('isi_konten', $data->isi_konten) }}</textarea>
                @error('isi_konten')
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
    
</script>
@endpush

