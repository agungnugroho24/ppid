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
    <a href="{{route('format-surat-adm')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
  </div>
  <h1>Kembali Ke Halaman Pengolahan Format Surat Permohonan Kunjungan</h1> 
</div>

<div class="section-body">
  <h2 class="section-title">Edit Data Format Surat Permohonan Kunjungan</h2>
  <p class="section-lead">
    On this page you can create a new post and fill in all fields.
  </p>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Form Edit Data Format Surat Permohonan Kunjungan</h4>
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
          <form id="form-post-content" action="{{ route('format-surat-adm-update',  $data->id) }}" method="POST" enctype="multipart/form-data">
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
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">File</label>
              <div class="col-sm-12 col-md-7"> 
                <div>
                  <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" onChange="getNameFile()">              
                  <input type="hidden" class="form-control" id="namefile_format" name="namefile_format" value="{{ old('namefile_format', $data->file) }}">  
                  <input type="hidden" class="form-control" id="old_namefile_format" name="old_namefile_format" value="{{ old('old_namefile_format', $data->file) }}">

                  @error('file')
                      <div class="alert alert-danger alert-block small">
                        <strong>{{ $message }}</strong>
                      </div>
                  @enderror               
                </div>  
                <div class="small mt-2"><span class="font-weight-bold text-danger">* </span>Ukuran File Maksimal 5Mb</div>                       
                <div class="small"><span class="font-weight-bold text-danger">* </span>Format File Harus .docx</div>                       
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

function getFile(filePath)
{
    return filePath.substr(filePath.lastIndexOf('\\') + 1).split('.')[0];
}

function getNameFile() 
{
    namefile_format.value = getFile(file.value);
    extension.value = file.value.split('.')[1];
} 
</script>
@endpush



