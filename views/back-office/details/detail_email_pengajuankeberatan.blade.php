@extends('back-office.layouts.master-2')

@section('title')
 {{ $title }}
@overwrite

@push('app-styles')
  <x-css-back-office/>
@endpush

@section('content')
<div class="section-header">
  <h1>{{ $title }}</h1>
</div>

<div class="section-body">

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5><i class="far fa-calendar-alt" style="font-size:1em;"></i>&nbsp;&nbsp;Tanggal Pengajuan : <span id="detail_nama_header">{{ date("d F Y, H:i", strtotime($data['created_at'])) }}</span></h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>A. INFORMASI PENGAJU KEBERATAN</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label>No. Pendaftaran</label>
                        <input type="text" class="form-control font-weight-bold" id="detail_no_pendaftaran" name="detail_no_pendaftaran" value="{{ $data['nomor_pendaftaran'] }}"  readonly>
                      </div>              
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                      <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control font-weight-bold" id="detail_nama" name="detail_nama" value="{{ $nama }}" readonly>
                        <input type="hidden" class="form-control font-weight-bold" id="data_alasankeberatan" name="data_alasankeberatan" value="{{ $data['alasan_keberatan'] }}" readonly>
                      </div>              
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label for="detail_tujuan_penggunaaninformasi">Tujuan Penggunaan Informasi</label>
                        <textarea class="form-control" id="detail_tujuan_penggunaaninformasi" name="detail_tujuan_penggunaaninformasi" rows="8" readonly>{{ $data['tujuan_penggunaaninformasi'] }}</textarea>
                      </div>                                                                    
                    </div>           
                  </div> 
                </div>
              </div>             
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>B. ALASAN PENGAJUAN KEBERATAN</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input alasan_keberatan" value="Permohonan Informasi Ditolak" name="alasan_keberatan[]" id="alasan_keberatan1" readonly>
                        <label class="custom-control-label" for="alasan_keberatan1">Permohonan Informasi Ditolak</label>
                      </div> 
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input alasan_keberatan" value="Informasi Berkala Tidak Disediakan" name="alasan_keberatan[]" id="alasan_keberatan2" readonly>
                        <label class="custom-control-label" for="alasan_keberatan2">Informasi Berkala Tidak Disediakan</label>
                      </div>  
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input alasan_keberatan" value="Permintaan Informasi Tidak Ditanggapi" name="alasan_keberatan[]" id="alasan_keberatan3" readonly>
                        <label class="custom-control-label" for="alasan_keberatan3">Permintaan Informasi Tidak Ditanggapi</label>
                      </div>  
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input alasan_keberatan" value="Permintaan Informasi Ditanggapi tidak sebagaimana yang diminta" name="alasan_keberatan[]" id="alasan_keberatan4" readonly>
                        <label class="custom-control-label" for="alasan_keberatan4">Permintaan Informasi Ditanggapi tidak sebagaimana yang diminta</label>
                      </div> 
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input alasan_keberatan" value="Permintaan Informasi Tidak Dipenuhi" name="alasan_keberatan[]" id="alasan_keberatan5" readonly>
                        <label class="custom-control-label" for="alasan_keberatan5">Permintaan Informasi Tidak Dipenuhi</label>
                      </div>  
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input alasan_keberatan" value="Biaya yang Dikenakan Tidak Wajar" name="alasan_keberatan[]" id="alasan_keberatan6" readonly>
                        <label class="custom-control-label" for="alasan_keberatan6">Biaya yang Dikenakan Tidak Wajar</label>
                      </div> 
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input alasan_keberatan" value="Informasi Disampaikan Melebihi Jangka Waktu yang Ditentukan" name="alasan_keberatan[]" id="alasan_keberatan7" readonly>
                        <label class="custom-control-label" for="alasan_keberatan7">Informasi Disampaikan Melebihi Jangka Waktu yang Ditentukan</label>
                      </div>                                                                                                      
                      <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input keberatan_lainnya" name="alasan_keberatan[]" id="alasan_keberatan8" value="" readonly>
                        <label class="custom-control-label" for="alasan_keberatan8">Lainnya</label>
                        <textarea class="form-control" id="text_alasan_keberatan" name="text_alasan_keberatan" rows="5" readonly></textarea>
                      </div>                                                                                                     
                    </div>           
                  </div> 
                </div>
              </div>             
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>C. KASUS POSISI</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <textarea class="form-control" id="detail_kasus_posisi" name="detail_kasus_posisi" rows="8" readonly>{{ $data['kasus_posisi'] }}</textarea>
                      </div>                                                                    
                    </div>           
                  </div> 
                </div>
              </div>            
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h4>D. HARI/TANGGAL TANGGAPAN ATAS KEBERATAN AKAN DIBERIKAN</h4>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label>Tanggal</label>
                        <input type="text" class="form-control" id="detail_tanggal_ataskeberatan" name="detail_tanggal_ataskeberatan" value="{{ date('d F Y', strtotime($data['tanggal_ataskeberatan'])) }}" readonly>
                      </div>                                                                    
                    </div>           
                  </div> 
                </div>
              </div>             
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('app-script')
<script>
$(document).ready(function() { 

      var daftarAlasan = $('#data_alasankeberatan').val();
      var checkchar = daftarAlasan.indexOf('#');
      var str = daftarAlasan.split("#");
      var tipeDaftarAlasan = typeof(str);

      if(checkchar > 0){
        if(tipeDaftarAlasan == 'object'){
          if(str.length > 1){
            $.each(str, function(index, item){
              $('input.alasan_keberatan').each(function(){
                this.disabled = true;
                if(this.value == item) {
                    this.checked = true;
                }else{
                  $('.keberatan_lainnya').prop('checked', true);
                  $('#text_alasan_keberatan').val(item);
                }
              });
            });
          }
        }
      }else{
        $('.keberatan_lainnya').attr('disabled', 'true');
        $('#alasan_keberatan8').prop('checked', true);
        $('textarea#text_alasan_keberatan').val(daftarAlasan);
      }

      if(tipeDaftarAlasan == 'object'){
        if(str.length > 1){
          $.each(str, function(index, item){
            $('input.alasan_keberatan').each(function(){
              this.disabled = true;
              if(this.value == item) {
                  this.checked = true;
              }else{
                $('.keberatan_lainnya').prop('checked', true);
                $('#text_alasan_keberatan').val(item);
              }
            });
          });
        }
      }else{
        $('.keberatan_lainnya').attr('disabled', 'true');
        $('#alasan_keberatan8').prop('checked', true);
        $('textarea#text_alasan_keberatan').val(daftarAlasan);
      } 
   

});  
</script>
@endpush
