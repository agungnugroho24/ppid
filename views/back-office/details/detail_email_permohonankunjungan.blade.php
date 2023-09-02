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
                <label for="detail_perihal_surat">Perihal Surat</label>
                <textarea class="form-control" id="detail_perihal_surat" name="detail_perihal_surat" rows="8" readonly>{{ $data['perihal_surat'] }}</textarea>
              </div> 
              <div class="form-group">
                <label for="detail_tema_konsultasi">Tema Konsultasi Pada Surat</label>
                <textarea class="form-control" id="detail_tema_konsultasi" name="detail_tema_konsultasi" rows="8" readonly>{{ $data['tema_konsultasi'] }}</textarea>
              </div>
              <div class="form-group">
                <label for="detail_unitkerja_tujuan">Unit Kerja Yang Dituju</label>
                <textarea class="form-control" id="detail_unitkerja_tujuan" name="detail_unitkerja_tujuan" rows="8" readonly>{{ $data['unitkerja_tujuan'] }}</textarea>
              </div>                                                                   
            </div>
            <div class="col-12 col-md-6 col-lg-6">
              <div class="form-group">
                <label>Waktu Kunjungan</label>
                <input type="text" class="form-control" id="detail_waktu_kunjungan" name="detail_waktu_kunjungan" value="{{ date('d F Y', strtotime($data['waktu_kunjungan'])) }}" readonly>
              </div>              
            </div>   
            <div class="col-12 col-md-6 col-lg-6">
              <div class="form-group">
                <label>Jumlah Peserta Kunjungan</label>
                <input type="text" class="form-control" id="detail_jumlah_peserta" name="detail_jumlah_peserta" value="{{ $data['jumlah_peserta'] }}" readonly>
              </div>              
            </div>                               
          </div> 
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


