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
            <div class="col-12 col-md-6 col-lg-6">
              <div class="form-group">
                <label>No. Pendaftaran</label>
                <input type="text" class="form-control font-weight-bold" id="detail_no_pendaftaran" name="detail_no_pendaftaran" value="{{ $data['nomor_pendaftaran'] }}" readonly>
              </div>              
            </div>
            <div class="col-12 col-md-6 col-lg-6">
              <div class="form-group">
                <label>Nama</label>
                <input type="text" class="form-control font-weight-bold" id="detail_nama" name="detail_nama" value="{{ $nama }}" readonly>
              </div>              
            </div>
            <div class="col-12 col-md-12 col-lg-12">
              <div class="form-group">
                <label for="detail_informasi_dibutuhkan">Informasi Yang Dibutuhkan</label>
                <textarea class="form-control" id="detail_informasi_dibutuhkan" name="detail_informasi_dibutuhkan" rows="8" readonly>{{ $data['informasi_dibutuhkan'] }}</textarea>
              </div> 
              <div class="form-group">
                <label for="detail_alasan_permintaan">Alasan Permintaan</label>
                <textarea class="form-control" id="detail_alasan_permintaan" name="detail_alasan_permintaan" rows="8" readonly>{{ $data['alasan_permintaan'] }}</textarea>
              </div>
              <div class="form-group">
                <label for="detail_alasan_penggunaan">Alasan Penggunaan Informasi</label>
                <textarea class="form-control" id="detail_alasan_penggunaan" name="detail_alasan_penggunaan" rows="8" readonly>{{ $data['alasan_penggunaan'] }}</textarea>
              </div>
              <div class="form-group">
                <label for="detail_bahan_informasi">Bahan Informasi</label>
                <textarea class="form-control" id="detail_bahan_informasi" name="detail_bahan_informasi" rows="8" readonly>{{ $data['bahan_informasi'] }}</textarea>
              </div>                                                                 
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


