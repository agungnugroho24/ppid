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
    <a href="{{route('post-laporan')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
  </div>
  <h1>Kembali Ke Halaman Pengolahan Konten Laporan</h1> 
</div>

<div class="section-body">
  <h2 class="section-title">Buat Post Konten Laporan</h2>
  <p class="section-lead">
    On this page you can create a new post and fill in all fields.
  </p>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Form Post Konten Laporan</h4>
        </div>

          @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
            </div>
          @endif 
        <div class="card-body">
          <form id="form-post-content" action="{{ route('post-laporan') }}" method="POST" enctype="multipart/form-data">
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
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
              <div class="col-sm-12 col-md-7">
                <select class="form-control selectric @error('kategori') is-invalid @enderror" id="kategori" name="kategori">
                  <option value="Akses Informasi Publik">Akses Informasi Publik</option>
                  <option value="Layanan Informasi Publik">Layanan Informasi Publik</option>
                  <option value="Survey Layanan Informasi Publik">Survey Layanan Informasi Publik</option>
                  <option value="Statistik Kunjungan Tamu">Statistik Kunjungan Tamu</option>
                </select>
                @error('kategori')
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
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Cover Image</label>
              <div class="col-sm-12 col-md-7">             
                <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" onChange="getNameFile()">              
                <input type="hidden" class="form-control" id="namefile_cover_image" name="namefile_cover_image">              
                @error('cover_image')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Data File</label>
              <div class="col-sm-12 col-md-7"> 
                <div>
                  <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" onChange="getNameFileUpload()">              
                  <input type="hidden" class="form-control" id="namefile_format" name="namefile_format" value="{{ old('namefile_format') }}">              
                  @error('file')
                      <div class="alert alert-danger alert-block small">
                        <strong>{{ $message }}</strong>
                      </div>
                  @enderror               
                </div>  
                <div class="small"><span class="font-weight-bold text-danger">* </span>Format File Harus .pdf</div>                       
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
CKEDITOR.replace( 'isi_konten' );
  
function getFile(filePath)
{
    return filePath.substr(filePath.lastIndexOf('\\') + 1).split('.')[0];
}

function getNameFile() 
{
    namefile_cover_image.value = getFile(cover_image.value);
    extension.value = cover_image.value.split('.')[1];
}

function getFileUpload(filePath)
{
    return filePath.substr(filePath.lastIndexOf('\\') + 1).split('.')[0];
}

function getNameFileUpload() 
{
    namefile_format.value = getFileUpload(file.value);
    extension.value = file.value.split('.')[1];
}

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



