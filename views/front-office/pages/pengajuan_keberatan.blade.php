@extends('front-office.layouts.master')

@section('title', 'Halaman Formulir Pengajuan Keberatan Informasi Publik')

@section('navbar')
  <x-navbar-home/>
@endsection

@section('mainsection')
    <x-header-home-area/>

    <!-- ======= Services Section ======= -->
    <div id="services" class="services-area area-padding">
        <div class="container">
            <div class="row justify-content-center">
              @include('sweetalert::alert')
              <div class="col-md-10">
                <form class="row mt-1" method="POST" action="{{ route('pengajuan-keberatan') }}" enctype="multipart/form-data">
                  @csrf
                    <div class="col-12 mb-3">
                      <div class="card">
                          <div class="card-header">
                            <b>{{ __('A. Informasi Pengaju Keberatan') }} </b>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="form-group col-12 col-sm-6">
                                <label>{{ __('No. Pendaftaran') }} </label>
                                <div class="">
                                  <div class="mb-3">
                                    <input id="nomor_pendaftaran" type="text" class="font-weight-bold form-control @error('nomor_pendaftaran') is-invalid @enderror" name="nomor_pendaftaran" value="{{ old('nomor_pendaftaran') }}" required autocomplete="nomor_pendaftaran" autofocus readonly placeholder="Formulir ID">
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
                                <label>{{ __('Tujuan Penggunaan Informasi') }}</label>
                                <div class="">
                                    <div class="mb-3">
                                      <textarea class="form-control @error('tujuan_penggunaaninformasi') is-invalid @enderror" id="tujuan_penggunaaninformasi" name="tujuan_penggunaaninformasi" rows="5" placeholder="Tujuan Penggunaan Informasi">{{ old('tujuan_penggunaaninformasi') }}</textarea>
                                    </div>
                                    @error('tujuan_penggunaaninformasi')
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

                    <div class="col-12 mb-3">
                      <div class="card">
                          <div class="card-header">
                            <b>{{ __('B. Alasan Pengajuan Keberatan') }}</b>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-12">
                                <div class="">
                                    <div class="mb-3">
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="Permohonan Informasi Ditolak" name="alasan_keberatan[]" id="alasan_keberatan1">
                                          <label class="form-check-label" for="alasan_keberatan1">
                                            Permohonan Informasi Ditolak
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="Informasi Berkala Tidak Disediakan" name="alasan_keberatan[]" id="alasan_keberatan2">
                                          <label class="form-check-label" for="alasan_keberatan2">
                                            Informasi Berkala Tidak Disediakan
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="Permintaan Informasi Tidak Ditanggapi" name="alasan_keberatan[]" id="alasan_keberatan3">
                                          <label class="form-check-label" for="alasan_keberatan3">
                                            Permintaan Informasi Tidak Ditanggapi
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="Permintaan Informasi Ditanggapi tidak sebagaimana yang diminta" name="alasan_keberatan[]" id="alasan_keberatan4">
                                          <label class="form-check-label" for="alasan_keberatan4">
                                            Permintaan Informasi Ditanggapi tidak sebagaimana yang diminta
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="Permintaan Informasi Tidak Dipenuhi" name="alasan_keberatan[]" id="alasan_keberatan5">
                                          <label class="form-check-label" for="alasan_keberatan5">
                                            Permintaan Informasi Tidak Dipenuhi
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="Biaya yang Dikenakan Tidak Wajar" name="alasan_keberatan[]" id="alasan_keberatan6">
                                          <label class="form-check-label" for="alasan_keberatan6">
                                            Biaya yang Dikenakan Tidak Wajar
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="Informasi Disampaikan Melebihi Jangka Waktu yang Ditentukan" name="alasan_keberatan[]" id="alasan_keberatan7">
                                          <label class="form-check-label" for="alasan_keberatan7">
                                            Informasi Disampaikan Melebihi Jangka Waktu yang Ditentukan
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="checkbox" value="" name="alasan_keberatan[]" id="alasan_keberatan8" onclick="mycheck()">
                                          <label class="form-check-label" for="text_alasan_keberatan8">
                                            Lainnya
                                          </label>
                                        </div> 
                                        <div class="form-check">
                                          <textarea class="form-control @error('text_alasan_keberatan') is-invalid @enderror" id="text_alasan_keberatan" name="text_alasan_keberatan" rows="5" cols="10" readonly placeholder="Lainnya (Klik terlebih dahulu untuk mengisi secara manual)"></textarea>
                                        </div>                                                               
                                    </div>
                                    @error('alasan_keberatan')
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

                    <div class="col-12 mb-3">
                      <div class="card">
                          <div class="card-header">
                            <b>{{ __('C. Kasus Posisi') }}</b>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="form-group col-12">
                                <div class="">
                                    <div class="mb-3">
                                      <textarea class="form-control @error('kasus_posisi') is-invalid @enderror" id="kasus_posisi" name="kasus_posisi" placeholder="Isi Detail Lengkap Kasus Posisi" rows="5">{{ old('kasus_posisi') }}</textarea>
                                    </div>
                                    @error('kasus_posisi')
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

                    <div class="col-12 mb-3">
                      <div class="card">
                          <div class="card-header">
                            <b>{{ __('D. Hari/Tanggal Tanggapan Atas Keberatan Akan Diberikan') }}</b>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="form-group col-12">
                                <label>{{ __('Tanggal') }}</label>
                                <div class="">
                                  <div class="mb-3 date-keberatan">
                                      <input id="tanggal_ataskeberatan" type="tanggal_ataskeberatan" class="form-control input-medium default-date-picker" name="tanggal_ataskeberatan" value="{{ old('tanggal_ataskeberatan') }}" autocomplete="off">
                                  </div>
                                    @error('tanggal_ataskeberatan')
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

                    <div class="col-12">
                      <div class="card">
                          <div class="card-header">
                            <b>{{ __('Ajukan') }}</b>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary w-100">{{ __('Submit') }}</button>
                              </div>
                          </div>    
                          </div>
                      </div>
                    </div>

                </form>
              </div>                
            </div>
        </div>
    </div>
    <!-- End Services Section -->

@endsection

@push('app-script')
<script>
$('.date-keberatan input').datepicker({
  format: 'yyyy-mm-dd',
  autoclose: true,
  orientation: 'bottom left',
});

function mycheck() {
  var checkBox = document.getElementById("alasan_keberatan8");
  var text = document.getElementById("text_alasan_keberatan");

  if (checkBox.checked == true){
    text.readOnly = false;
  } else {
    text.readOnly = true;
  }
}

$(document).ready(function() {
    $('#text_alasan_keberatan').change( function(){
        $('#text_alasan_keberatan').val();
        $('#alasan_keberatan8').val($(this).val());
    });

    $(window).click(function() {
        $.ajaxSetup({
           headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
        });   
             
        $.ajax({          
            url: '{{ url('nomor-pendaftaran/pengajuan-keberatan') }}',
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
