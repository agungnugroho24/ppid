@extends('back-office.layouts.master')

@section('title')
 {{ $title }}
@overwrite

@push('app-styles')
  <x-css-back-office/>
@endpush

@section('content')
<div class="section-header">
  <h1>{{ $title }}</h1>
  <div class="section-header-button">
    <a href="{{route('kirim-email-adm-create')}}" class="btn btn-primary">Tambah Baru</a>
  </div>   
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
            <table class="table table-striped" id="table-penerima-email-notifikasi">
              <thead>
                <tr>
                  <th rowspan="2" class="text-center details-data"></th>
                  <th rowspan="2">Nama Penerima</th>
                  <th rowspan="2">Alamat Email</th>
                  <th rowspan="2">Status Kirim Email</th>
                  <th colspan="3" class="text-center">Action</th>
                </tr>
                <tr>
                    <th class="text-center">Active</th>
                    <th class="text-center">Update</th>
                    <th class="text-center">Delete</th>
                </tr>                 
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="align-middle"></td>
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
<div class="modal fade" tabindex="-1" role="dialog" id="statusPermintaanModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Status Permintaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="" enctype="multipart/form-data" class="" id="modal-status-permintaan">
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
                <select class="form-control" id="status_permintaan_informasi" name="status_permintaan_informasi">
                  {{--@foreach($status as $datastatus)--}}
                  <option value="{{-- $datastatus->nama_status_singkat --}}">{{-- $datastatus->nama_status_singkat --}}</option>
                  {{--@endforeach--}}
                </select>
                <input type="hidden" class="form-control" value="" name="id_permintaan" id="id_permintaan">
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
  var table = $('#table-penerima-email-notifikasi').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ url('bo/json/kirim-email-notifikasi') }}',
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
                  return "<span class='text-modify-1 font-weight-bold no-pendaftaran' data-toggle='modal' data-target='#modalDetailPermintaanInformasi'>"+data+"</span>";
              },
          },        
          {
              "targets": [ 2 ], 
              "visible": true,
              "searchable": true
          },                 
          {
              "targets": [ 3 ], 
              "visible": true,
              "searchable": true,
              "className": 'dt-center cell-statuskirimemail medium',
              render: function(data) {
                  if(data == 1){
                    return "<p class='text-success font-weight-bold'>Active</p>";
                  }else{
                    return "<p class='text-danger font-weight-bold'>Deactive</p>";
                  }                  
              }
          },         
          {
              "targets": [ -3 ], 
              "visible": true,
              "searchable": false,
              "className": 'dt-center cell-button-publish',
              "orderable": false,
          },                         
          {
              "targets": [ -2 ], 
              "visible": true,
              "searchable": false,
              "className": 'dt-center cell-button-update',
              "orderable": false,
          }, 
          {
              "targets": [ -1 ], 
              "visible": true,
              "searchable": false,
              "className": 'dt-center cell-button-delete',
              "orderable": false,
          },                                        
      ],        
      columns: [
          { "data": "" },
          { "data": "nama_penerima" },
          { "data": "email" },
          { "data": "is_active" },
          { "data": "active" },
          { "data": "update" },
          { "data": "delete" },
      ],
            
  });  

  //Add event listener for opening and closing details
  $('#table-penerima-email-notifikasi tbody').on('click', 'button.details-data', function () {
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

  $('#table-penerima-email-notifikasi tbody').on('click', '.hard-delete-confirm', function (event) {
      event.preventDefault();
      const url = $(this).attr('href');
      swal({
          title: 'Apakah anda yakin.?',
          text: 'Data ini akan dihapus secara permanen.!',
          icon: 'warning',
          buttons: ["Cancel", "Yes"],
      }).then(function(value) {
          if (value) {
              window.location.href = url;
          }
      });
  }); 

  $('#table-penerima-email-notifikasi tbody').on('click', '.soft-delete-confirm', function (event) {
      event.preventDefault();
      const url = $(this).attr('href');
      swal({
          title: 'Apakah anda yakin.?',
          text: 'Data ini akan dihapus, Namun tidak dihapus secara permanen',
          icon: 'warning',
          buttons: ["Cancel", "Yes"],
      }).then(function(value) {
          if (value) {
              window.location.href = url;
          }
      });
  });   



});  
</script>
@endpush

