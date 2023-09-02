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
  <h2 class="section-title">Edit Post Konten Laporan</h2>
  <p class="section-lead">
    On this page you can create a new post and fill in all fields.
  </p>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Form Edit Post Laporan</h4>
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
          <form id="form-post-content" action="{{ route('post-laporan-update',  $data->id) }}" method="POST" enctype="multipart/form-data">
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
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
              <div class="col-sm-12 col-md-7">
                <select class="form-control selectric @error('kategori') is-invalid @enderror" id="kategori" name="kategori">
                  <option value="{{ old('kategori', 'Akses Informasi Publik') }}" @if (old('kategori') == 'Akses Informasi Publik' || $data->kategori == 'Akses Informasi Publik') selected="selected" @endif>Akses Informasi Publik</option>
                  <option value="{{ old('kategori', 'Layanan Informasi Publik') }}" @if (old('kategori') == 'Layanan Informasi Publik' || $data->kategori == 'Layanan Informasi Publik') selected="selected" @endif>Layanan Informasi Publik</option>
                  <option value="{{ old('kategori', 'Survey Layanan Informasi Publik') }}" @if (old('kategori') == 'Survey Layanan Informasi Publik' || $data->kategori == 'Survey Layanan Informasi Publik') selected="selected" @endif>Survey Layanan Informasi Publik</option>
                  <option value="{{ old('kategori', 'Statistik Kunjungan Tamu') }}" @if (old('kategori') == 'Statistik Kunjungan Tamu' || $data->kategori == 'Statistik Kunjungan Tamu') selected="selected" @endif>Statistik Kunjungan Tamu</option>
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
                <textarea class="summernote-simple @error('isi_konten') is-invalid @enderror" rows="5" cols="90" id="isi_konten" name="isi_konten">{{ old('isi_konten', $data->isi_konten) }}</textarea>
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
                <input type="hidden" class="form-control" id="namefile_cover_image" name="namefile_cover_image" value="{{ old('namefile_cover_image', $data->cover_image) }}">              
                <input type="hidden" class="form-control" id="old_namefile_cover_image" name="old_namefile_cover_image" value="{{ old('old_namefile_cover_image', $data->cover_image) }}">              
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
                  <input type="hidden" class="form-control" id="namefile_format" name="namefile_format" value="{{ old('namefile_format', $data->data_file) }}">  
                  <input type="hidden" class="form-control" id="old_namefile_format" name="old_namefile_format" value="{{ old('old_namefile_format', $data->data_file) }}">

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
</script>
@endpush



