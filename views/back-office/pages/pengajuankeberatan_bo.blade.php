@extends('back-office.layouts.master')

@section('title')
  {{ $title }}
@endsection

@push('app-styles')
  <x-css-back-office/>
@endpush

@section('content')
<div class="section-header">
  <h1>{{$title}}</h1>
</div>

<div class="section-body">

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4></h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="table-pengajuan-keberatan">
              <thead>
                <tr>
                  <th class="text-center details-data"></th>
                  <th>No. Pendaftaran</th>
                  <th>Nama Pemohon</th>
                  <th>Tujuan Penggunaan Informasi</th>
                  <th>Alasan Keberatan</th>
                  <th>Tanggal Pengajuan</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td class="align-middle"></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td><div class="badge badge-success"></div></td>
                  <td><a href="#" class="btn btn-secondary"></a></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('modal-status')
<div class="modal fade" tabindex="-1" role="dialog" id="statusPengajuanKeberatanModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Status Permintaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="" enctype="multipart/form-data" class="" id="modal-status-pengajuankeberatan">
        <div class="modal-body">
            @csrf
            <div class="form-group">
              <label>Status Permintaan</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-marker"></i>
                  </div>
                </div>
                <select class="form-control" id="status_pengajuan_keberatan" name="status_pengajuan_keberatan">
                  @foreach($status as $datastatus)
                  <option value="{{ $datastatus->nama_status_singkat }}">{{ $datastatus->nama_status_singkat }}</option>
                  @endforeach
                </select>
                <input type="hidden" class="form-control" value="" name="id_pengajuankeberatan" id="id_pengajuankeberatan">
              </div>
            </div>
            <div class="form-group row_alasan_penolakan" style="display:none;">
              <label for="alasan_penolakan">Alasan Penolakan</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="far fa-comment-dots"></i>
                  </div>
                </div>
                <textarea class="form-control" id="alasan_penolakan" name="alasan_penolakan" rows="10"></textarea>
              </div>    
            </div>             
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('modal-detail')
<div class="modal fade" tabindex="-1" role="dialog" id="modalDetailPengajuanKeberatan">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-file-signature" style="font-size:1em;"></i>&nbsp;&nbsp;FORMULIR PENGAJUAN KEBERATAN ATAS PERMINTAAN INFORMASI</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-header">
              <h4>A. INFORMASI PENGAJU KEBERATAN</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label>No. Pendaftaran</label>
                    <input type="text" class="form-control" id="detail_no_pendaftaran" name="detail_no_pendaftaran" readonly>
                  </div>              
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                  <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" id="detail_nama" name="detail_nama" readonly>
                  </div>              
                </div>
                <div class="col-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <label for="detail_tujuan_penggunaaninformasi">Tujuan Penggunaan Informasi</label>
                    <textarea class="form-control" id="detail_tujuan_penggunaaninformasi" name="detail_tujuan_penggunaaninformasi" rows="8" readonly></textarea>
                  </div>                                                                    
                </div>           
              </div> 
            </div>
          </div> 
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
          <div class="card">
            <div class="card-header">
              <h4>C. KASUS POSISI</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <textarea class="form-control" id="detail_kasus_posisi" name="detail_kasus_posisi" rows="8" readonly></textarea>
                  </div>                                                                    
                </div>           
              </div> 
            </div>
          </div>  
          <div class="card">
            <div class="card-header">
              <h4>D. HARI/TANGGAL TANGGAPAN ATAS KEBERATAN AKAN DIBERIKAN</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                  <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" class="form-control" id="detail_tanggal_ataskeberatan" name="detail_tanggal_ataskeberatan" readonly>
                  </div>                                                                    
                </div>           
              </div> 
            </div>
          </div>                                                 
        </div>
        <div class="modal-footer bg-whitesmoke br">
        </div>
    </div>
  </div>
</div>
@endsection

@push('app-script')
<script>
function format(data) {
  var alasanPenolakan = data.alasan_penolakan;
  var rowAlasanPenolakan;
  if(alasanPenolakan){
    rowAlasanPenolakan = '<tr style="font-weight:bold;"> <td width="15%">&nbsp;Alasan Penolakan</td> <td width="2%">:</td> <td>'+alasanPenolakan+'</td></tr>';
  }else{
    rowAlasanPenolakan = '';
  }  
  return '<table cellpadding="10" cellspacing="0" width="100%" border="0" style="margin-left:0px;">'+
              rowAlasanPenolakan+                                                         
          '</table>';

}  

$(document).ready(function() {
  var table = $('#table-pengajuan-keberatan').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ url('bo/json/pengajuan-keberatan') }}',
      columnDefs: [
          {
              "targets": [ 0 ],
              "data": null,
              "orderable": false,
              "className": 'dt-center',
              "defaultContent": "<button class='details-data' title='data-detail'></button>",
          },
          {
              "targets": [ 1 ], 
              "visible": true,
              "searchable": true,
              "className": 'dt-center cell-detail-datapermintaan',
              "render": function(data){
                  return "<span class='text-modify-1 font-weight-bold no-pendaftaran' data-toggle='modal' data-target='#modalDetailPengajuanKeberatan'>"+data+"</span>";
              },              
              // "defaultContent": "<span class='btn btn-info' data-toggle='modal' data-target='#modalDetailPengajuanKeberatan'>No-Pendaftaran</span>",              
          },        
          {
              "targets": [ 2 ], 
              "visible": true,
              "searchable": true
          },         
          {
              "targets": [ 3 ], 
              "visible": true,
              "searchable": true
          },         
          {
              "targets": [ 4 ], 
              "visible": true,
              "searchable": true
          },         
          {
              "targets": [ 5 ], 
              "visible": true,
              "searchable": true
          },    
          {
              "targets": [ 6 ], 
              "visible": true,
              "searchable": true,
              "className": 'dt-center cell-statuspermintaan medium',
              render: function(data) {
                  var statuspermintaan = "Permohonan&nbsp;"+data;
                  if(data == "Menunggu approval"){
                    var textdata = data.split(" ").join('&nbsp;');
                    return textdata;
                  }      
                  if(data == "Permohonan diterima"){
                    return data;
                  }                              
                  // if(data == "Diterima"){
                  //   return '<button class="small status-diterima">'+statuspermintaan+'</button>';
                  // }else if(data == "Diteruskan"){
                  //   return '<button class="small status-diteruskan">'+statuspermintaan+'</button>';
                  // }else if(data == "Diproses"){
                  //   return '<button class="small status-diproses">'+statuspermintaan+'</button>';
                  // }else if(data == "Ditanggapi"){
                  //   return '<button class="small status-ditanggapi">'+statuspermintaan+'</button>';
                  // }else if(data == "Ditolak"){
                  //   return '<button class="small status-ditolak">'+statuspermintaan+'</button>';
                  // }else if(data == "Selesai"){
                  //   return '<button class="small status-selesai">'+statuspermintaan+'</button>';
                  // }
                  return statuspermintaan;
              }
          },                
          {
              "targets": [ -1 ], 
              "visible": true,
              "searchable": false,
              "orderable": false,
              "className": 'dt-center cell-action-statuspermintaan',
          },                                         
      ],        
      columns: [
          { "data": "" },
          { "data": "nomor_pendaftaran" },
          { "data": "name" },
          { "data": "tujuan_penggunaaninformasi" },
          { "data": "alasan_keberatan_list" },
          { "data": "created_at" },
          { "data": "status_permintaan" },
          { "data": "status_update" },
      ],  
      "rowCallback": function( row, data, index ) {
          var statuspermintaan = "Permohonan&nbsp;"+data.status_permintaan;

          if ( data.status_permintaan == "Menunggu approval" )
          {
              $('td.cell-statuspermintaan', row).addClass('status-menunggu-approval');
          } 

          if ( data.status_permintaan == "Permohonan diterima" )
          {
              $('td.cell-statuspermintaan', row).addClass('status-diterima');
          } 

          if ( data.status_permintaan == "Diteruskan" )
          {
              $('td.cell-statuspermintaan', row).addClass('status-diteruskan');
          }

          if ( data.status_permintaan == "Diproses" )
          {
              $('td.cell-statuspermintaan', row).addClass('status-diproses');
          }

          if ( data.status_permintaan == "Ditanggapi" )
          {
              $('td.cell-statuspermintaan', row).addClass('status-ditanggapi');
          }

          if ( data.status_permintaan == "Ditolak oleh PPID" )
          {
              $('td.cell-statuspermintaan', row).addClass('status-ditolak-ppid');
          } 

          if ( data.status_permintaan == "Ditolak oleh Unit Kerja" )
          {
              $('td.cell-statuspermintaan', row).addClass('status-ditolak-uk');
          } 

          if ( data.status_permintaan == "Selesai" )
          {
              $('td.cell-statuspermintaan', row).addClass('status-selesai');
          }                   

      }              
  });  

  //Add event listener for opening and closing details
  $('#table-pengajuan-keberatan tbody').on('click', 'button.details-data', function () {
      var tr = $(this).closest('tr');
      var row = table.row(tr);

      if ( row.child.isShown() ) {
          row.child.hide();         
          tr.removeClass('shown');
      }
      else {              
          row.child( format(row.data()) ).show();
          tr.addClass('shown');
      }
  });  

  //Add event listener for change status
  $('#table-pengajuan-keberatan tbody').on('click', 'td.cell-action-statuspermintaan', function(e) {
      e.preventDefault();
      var data = table.row( $(this).parents('tr') ).data(); 
      var vals = data.status_permintaan;
      $("#id_pengajuankeberatan").val(data.id);
      $("#status_pengajuan_keberatan").val(data.status_permintaan);
      $("#alasan_penolakan").val(data.alasan_penolakan);
      $("#modal-status-pengajuankeberatan").attr('action', data.route_status_update);
  
      if(vals == "Ditolak oleh Unit Kerja" || vals == "Ditolak oleh PPID"){
        $('.row_alasan_penolakan').show();
      }else{
        $('.row_alasan_penolakan').hide();
      }      
  }); 

  $('#status_pengajuan_keberatan').on('change', function(e){
    var vals = $(this).val();
    if(vals == "Ditolak oleh Unit Kerja" || vals == "Ditolak oleh PPID"){
      $('.row_alasan_penolakan').show();
    }else{
      $('.row_alasan_penolakan').hide();
    }
  }); 

  $('#table-pengajuan-keberatan tbody').on('click', 'td.cell-detail-datapermintaan', function(e) {
      e.preventDefault();
      var data = table.row( $(this).parents('tr') ).data(); 
      var daftarAlasan = data.alasan_keberatan;
      var tipeDaftarAlasan = typeof(data.alasan_keberatan);
      $("#detail_no_pendaftaran").val(data.nomor_pendaftaran);
      $("#detail_nama").val(data.name);
      $("#detail_tujuan_penggunaaninformasi").val(data.tujuan_penggunaaninformasi);
      $("#detail_kasus_posisi").val(data.kasus_posisi);
      $("#detail_tanggal_ataskeberatan").val(data.tanggal_ataskeberatan);

      if(tipeDaftarAlasan == 'object'){
        if(daftarAlasan.length > 1){
          $.each(daftarAlasan, function(index, item){
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
        $('#text_alasan_keberatan').val(data.alasan_keberatan);
      } 
  }); 

  $('#modalDetailPengajuanKeberatan').on('hidden.bs.modal', function (e) {
    $(this)
      .find("input[type=checkbox]")
         .prop("checked", false)
         .end();
  })    

});  
</script>
@endpush

