@extends('front-office.layouts.master')

@section('title', 'Halaman Formulir Permintaan Informasi Publik')

@section('navbar')
  <x-navbar-home/>
@endsection

@section('topsection')
  <x-header-home-area/>
@endsection

@section('mainsection')

    <!-- ======= Services Section ======= -->
    <div id="services" class="services-area area-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-file-text-o" style="font-size:1.8em;"></i> <b>{{ __('Formulir Permintaan Informasi Publik') }}</b>
                            @include('sweetalert::alert')
                        </div>
                        <div class="card-body">
                            <form class="row" method="POST" action="{{ route('informasi-publik') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group col-12 col-sm-6">
                                    <label>{{ __('No. Pendaftaran') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                            <input id="nomor_pendaftaran" type="text" class="font-weight-bold form-control @error('nomor_pendaftaran') is-invalid @enderror" name="nomor_pendaftaran" value="{{ old('nomor_pendaftaran') }}" required autocomplete="nomor_pendaftaran" placeholder="Formulir ID" autofocus readonly>
                                            <input id="nomor_urut" type="hidden" class="form-control" name="nomor_urut" value="{{ old('nomor_urut') }}" readonly> 
                                        </div>
                                        @error('nomor_pendaftaran')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-12 col-sm-6">
                                    <label>{{ __('Nama Lengkap') }}</label>
                                    <div class="">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" placeholder="Nama Lengkap" readonly>
                                        <input id="id_user" type="hidden" class="form-control" name="id_user" value="{{ Auth::user()->id }}">
                                    </div>                                    
                                </div>

                                <div class="form-group col-12 col-sm-6">
                                    <label>{{ __('Email') }}</label>
                                    <div class="">
                                        <input id="email" type="text" class="form-control" name="email" value="{{ Auth::user()->email }}" placeholder="Email" readonly>
                                        <input id="id_user" type="hidden" class="form-control" name="id_user" value="{{ Auth::user()->id }}">
                                    </div> 
                                </div>
                                <div class="form-group col-12 col-sm-6">
                                    <label>{{ __('No. Ponsel') }}</label>
                                    <div class="">
                                        <input id="ponsel" type="text" class="form-control" name="ponsel" value="{{ Auth::user()->nomor_ponsel }}" placeholder="No. Ponsel" readonly>
                                        <input id="id_user" type="hidden" class="form-control" name="id_user" value="{{ Auth::user()->id }}">
                                    </div>                                    
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Informasi Yang dibutuhkan') }}</label>
                                    </textarea>
                                    <div class="">
                                        <div class="mb-3">
                                          <textarea class="form-control @error('informasi_dibutuhkan') is-invalid @enderror" id="informasi_dibutuhkan" name="informasi_dibutuhkan" rows="5" placeholder="Informasi yang dibutuhkan">{{ old('informasi_dibutuhkan') }}</textarea>
                                        </div>
                                        @error('informasi_dibutuhkan')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror                                     
                                    </div>                                    
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Alasan Permintaan') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                          <textarea class="form-control @error('alasan_permintaan') is-invalid @enderror" id="alasan_permintaan" name="alasan_permintaan" rows="5" placeholder="Alasan Permintaan">{{ old('alasan_permintaan') }}</textarea>
                                        </div>
                                        @error('alasan_permintaan')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>                                    
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Alasan Penggunaan Informasi') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                          <textarea class="form-control" id="alasan_penggunaan" name="alasan_penggunaan" rows="5" placeholder="Alasan Penggunaan Informasi">{{ old('alasan_penggunaan')}}</textarea>
                                        </div>
                                        @error('alasan_penggunaan')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror                                        
                                    </div>                                    
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Bahan Informasi') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                          <textarea class="form-control" id="bahan_informasi" name="bahan_informasi" rows="5" placeholder="Bahan Informasi">{{ old('bahan_informasi') }}</textarea>
                                        </div>
                                        @error('bahan_informasi')
                                            <div class="alert alert-danger alert-block small">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>                                    
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Lampiran') }}</label>
                                    <div class="">
                                        <input type="file" class="form-control-file @error('dokumen') is-invalid @enderror" name="dokumen" id="dokumen" onChange="getNameFile()">
                                        <input type='hidden' id='namefile' name='namefile'>
                                        <div>
                                            <ul class="small">
                                                <li>
                                                    <span class="font-weight-bold text-danger">* </span>Lampiran bisa berupa Kartu Identitas seperti KTP/SIM atau Akta Notaris/Surat Pengesahan untuk badan swasta
                                                </li>                                                 
                                                <li>
                                                    <span class="font-weight-bold text-danger">* </span>Maksimal 20Mb
                                                </li>
                                                <li>
                                                    <span class="font-weight-bold text-danger">* </span>Format file harus JPEG atau PDF
                                                </li>  
                                                <li>
                                                    <span class="font-weight-bold text-danger">* </span>Lampiran Akta Notaris/Surat Pengesahan untuk badan swasta, di scan dan diubah menjadi file PDF
                                                </li>                                                  
                                            </ul>
                                        </div>
                                        @error('dokumen')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror                                        
                                    </div>                                    
                                </div>

                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary w-100">{{ __('Submit') }}</button>
                                </div>
                            </form>     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Services Section -->

@endsection

@push('app-script')
<script>
function getFile(filePath)
{
    return filePath.substr(filePath.lastIndexOf('\\') + 1).split('.')[0];
}

function getNameFile() 
{
    namefile.value = getFile(dokumen.value);
    extension.value = dokumen.value.split('.')[1];
}

$(document).ready(function() {
    $(window).click(function() {
        $.ajaxSetup({
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
        });   
             
        $.ajax({          
            url: "{{ url('nomor-pendaftaran/permintaan-informasi') }}",
            type: 'GET',
            // dataType: 'json',
            success: function(data) {
                $("#nomor_pendaftaran").val(data.no_pendaftaran);
                $("#nomor_urut").val(data.no_urut);
            },
            fail: function() {
                // alert("ajax gagal");
            }
        });
    });
});
  
</script>
@endpush
