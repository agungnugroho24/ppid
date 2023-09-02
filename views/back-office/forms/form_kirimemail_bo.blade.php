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
    <a href="{{route('kirim-email-adm')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
  </div>
  <h1>Kembali Ke Halaman Pengolahan Penerima Email Notifikasi</h1> 
</div>

<div class="section-body">
  <h2 class="section-title">Buat Post Penerima Email Notifikasi</h2>
  <p class="section-lead">
    On this page you can create a new post and fill in all fields.
  </p>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4>Form Post Penerima Email Notifikasi</h4>
        </div>

          @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{ $message }}</strong>
            </div>
          @endif 
        <div class="card-body">
          <form id="form-post-content" action="{{ route('kirim-email-adm') }}" method="POST" enctype="multipart/form-data">
            @csrf          
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Penerima</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" id="nama_penerima" name="nama_penerima" class="form-control @error('nama_penerima') is-invalid @enderror" value="{{ old('nama_penerima') }}">
                <input id="created_by" type="hidden" class="form-control" name="created_by" value="{{ Auth::user()->id }}">
                @error('nama_penerima')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>
<!--             <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
              <div class="col-sm-12 col-md-7">
                <select class="form-control selectric @error('kategori') is-invalid @enderror" id="kategori" name="kategori">
                  <option value="Berkala">Berkala</option>
                  <option value="Serta Merta">Serta Merta</option>
                  <option value="Setiap Saat">Setiap Saat</option>
                </select>
                @error('kategori')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div> -->
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Alamat Email</label>
              <div class="col-sm-12 col-md-7">
                <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')
                    <div class="alert alert-danger alert-block small">
                      <strong>{{ $message }}</strong>
                    </div>
                @enderror               
              </div>
            </div>      
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status Kirim Email</label>
              <div class="col-sm-12 col-md-7 ">
                <label class="custom-switch mt-2">
                  <input type="checkbox" name="status_post_checkbox" id="status_post_checkbox" class="custom-switch-input @error('status_post_checkbox') is-invalid @enderror">
                  <input type="hidden" name="status_kirim_email" id="status_kirim_email" class="status_kirim_email" value="deactive">
                  <span class="custom-switch-indicator"></span>
                  <span class="custom-switch-description">Saya ingin mengizinkan notifikasi dikirim ke alamat email ini.</span>
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

$(document).ready(function() {
  $('#status_post_checkbox').click(function() {
    if($(this).prop("checked") == true){
        $('#status_kirim_email').val("active");
    }
    else if($(this).prop("checked") == false){
        $('#status_kirim_email').val("deactive");
    }    
  });
});  
</script>
@endpush


