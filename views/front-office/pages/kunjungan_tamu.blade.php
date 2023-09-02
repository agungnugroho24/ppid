@extends('front-office.layouts.master')

@section('title', 'Halaman Formulir Permohonan Kunjungan Tamu')

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
                            <i class="fa fa-file-text-o" style="font-size:1.8em;"></i> <b>{{ __('Formulir Permohonan Kunjungan Tamu') }}</b>
                            @include('sweetalert::alert')
                        </div>
                        <div class="card-body">
                            <form class="row" method="POST" action="{{ route('kunjungan-tamu') }}" enctype="multipart/form-data">
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
                                        <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" placeholder="Nama Lengkap" disabled>
                                        <input id="id_user" type="hidden" class="form-control" name="id_user" value="{{ Auth::user()->id }}">
                                    </div>                                    
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Perihal Surat') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                          <textarea class="form-control @error('perihal_surat') is-invalid @enderror" id="perihal_surat" name="perihal_surat" rows="5" placeholder="Perihal Surat">{{ old('perihal_surat') }}</textarea>
                                        </div>
                                        @error('perihal_surat')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>                                    
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Tema Konsultasi Pada Surat') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                          <input id="tema_konsultasi" type="text" class="form-control @error('tema_konsultasi') is-invalid @enderror" name="tema_konsultasi" value="{{ old('tema_konsultasi') }}" placeholder="Tema Konsultasi Pada Surat">
                                        </div>
                                        @error('tema_konsultasi')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror                                        
                                    </div>                                    
                                </div>

                                <div class="form-group col-12">
                                    <label>{{ __('Unit Kerja yang Dituju') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                            @empty($unitkerja)
                                                <input id="unitkerja_tujuan" type="text" class="form-control @error('unitkerja_tujuan') is-invalid @enderror" name="unitkerja_tujuan" value="{{ old('unitkerja_tujuan') }}" placeholder="Unit Kerja yang Dituju">
                                            @endempty
                                            @isset($unitkerja)
                                                <select class="form-control" id="unitkerja_tujuan" name="unitkerja_tujuan" placeholder="Unit Kerja yang Dituju" style="width:100%;height: 10%">
                                                    <option value=""></option>
                                                    @foreach($unitkerja as $data)
                                                    <option value="{{ $data['nama'] }}"  {{ old('unitkerja_tujuan') == $data['nama'] ? 'selected' : '' }}>{{$data['nama']}}</option>
                                                    @endforeach
                                                </select>
                                            @endisset

                                        </div>
                                        @error('unitkerja_tujuan')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>                                    
                                </div>

                                <div class="form-group col-12 col-sm-6">
                                    <label>{{ __('Waktu Kunjungan') }}</label>
                                    <div class="">
                                        <div class="mb-3 date-kunjungan input-group">
                                            <input id="waktu_kunjungan" type="text" class="form-control input-medium default-date-picker" name="waktu_kunjungan" value="{{ old('waktu_kunjungan') }}" autocomplete="off" placeholder="Waktu Kunjungan" aria-describedby="date-addon2">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="date-addon2"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                            </div>                                            
                                        </div>
                                        @error('waktu_kunjungan')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror                                    
                                    </div>                                    
                                </div>

                                <div class="form-group col-12 col-sm-6">
                                    <label>{{ __('Jumlah Peserta Kunjungan') }}</label>
                                    <div class="">
                                        <div class="mb-3">
                                            <input id="jumlah_peserta" type="jumlah_peserta" class="form-control" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}" placeholder="Jumlah Peserta Kunjungan"> 
                                        </div>
                                        @error('jumlah_peserta')
                                            <div class="alert alert-danger alert-block small">
                                              <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror                                      
                                    </div>                                    
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-12">
                                                    @empty($path)
                                                       <a href="javascript:void(0)" class="btn btn-warning" style="cursor:not-allowed;" disabled title="Hubungi sekretariat PPID untuk meminta format surat">Download Format Surat</a>                                  
                                                    @endempty

                                                    @isset($path)
                                                        <a href="{{ route('get-format-surat-kunjungan') }}" class="btn btn-warning">Download Format Surat</a>
                                                    @endisset
                                                    <p class="small"><span class="font-weight-bold text-danger">* </span>Silahkan unduh terlebih dahulu format surat yang akan diajukan</p>
                                                </div>
                                                <div class="form-group col-12">
                                                    <label>{{ __('Upload Surat') }}</label>
                                                    <div class="">
                                                        <input type="file" class="form-control-file @error('dokumen') is-invalid @enderror" name="dokumen" id="dokumen" onChange="getNameFile()">
                                                        <input type='hidden' id='namefile' name='namefile'>
                                                        <div>
                                                            <ul class="small">                               
                                                                <li>
                                                                    <span class="font-weight-bold text-danger">* </span>Maksimal 2Mb
                                                                </li>
                                                                <li>
                                                                    <span class="font-weight-bold text-danger">* </span>Format file harus PDF
                                                                </li>                                              
                                                            </ul>
                                                        </div>                                                        

                                                        <!-- <p class="small"><span class="font-weight-bold text-danger">* </span>Maksimal 2Mb</p> -->
                                                        @error('dokumen')
                                                            <div class="alert alert-danger alert-block small">
                                                              <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror                                        
                                                    </div>                                                    
                                                </div>
                                            </div>
                                        </div>
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
}
    
$('.date-kunjungan input').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    orientation: 'bottom left',
});

$(document).ready(function() {
    var status = '{{ $status }}';
    if(status == 200){
        $("#unitkerja_tujuan").select2();
    }

    $(window).click(function() {
        $.ajaxSetup({
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
        });   
             
        $.ajax({          
            url: '{{ url('nomor-pendaftaran/permohonan-kunjungan') }}',
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
