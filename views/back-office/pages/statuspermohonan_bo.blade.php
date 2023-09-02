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
  </div>  
</div>

<div class="section-body">
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <!-- <h4><a href="{{route('status-permohonan-adm-create')}}" class="btn btn-primary">Tambah Baru</a></h4> -->
        </div>
        <div class="card-body">         
          <div class="table-responsive">
            <table class="table table-striped" id="table-status-permohonan">
              <thead>
                <tr>
                  <th class="text-center details-data" rowspan="2"></th>
                  <th rowspan="2">Nama Status</th>
                  <th rowspan="2">Nama Status(Singkat)</th>
                  <th colspan="2" class="text-center">Action</th>
                </tr>
                <tr>
                    <th class="text-center">Update</th>
                    <th class="text-center">Delete</th>
                </tr>                
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td><div class="badge badge-success"></div></td>
                  <td></td>
                  <td></td>
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

@push('app-script')
<script>
function format(data) {
  return '<table cellpadding="10" cellspacing="0" width="100%" border="0" style="margin-left:0px;">'+
              '<tr style="font-weight:bold;">'+
                  '<td width="15%">&nbsp;Dibuat Pada Tanggal</td>'+
                  '<td width="2%">:</td>'+
                  '<td>'+data.created_at+'</td>'+
              '</tr>'+
              '<tr style="font-weight:bold;">'+
                  '<td width="15%">&nbsp;Diperbarui Pada Tanggal</td>'+
                  '<td width="2%">:</td>'+
                  '<td>'+data.updated_at+'</td>'+
              '</tr>'+                                                                                  
          '</table>';

}  

$(document).ready(function() {
  var table = $('#table-status-permohonan').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ url('bo/json/status-permohonan') }}',
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
              "searchable": true
          },        
          {
              "targets": [ 2 ], 
              "visible": true,
              "searchable": true
          },         
          {
              "targets": [ -1 ], 
              "visible": true,
              "className": 'dt-center',
              "searchable": false,
              "orderable": false,
          },                  
          {
              "targets": [ -2 ], 
              "visible": true,
              "searchable": false,
              "className": 'dt-center',
              "orderable": false,
          },                                                            
      ],        
      columns: [
          { "data": "" },
          { "data": "nama_status" },
          { "data": "nama_status_singkat" },
          { "data": "update" },
          { "data": "delete" },
          // { "data": "kategori" },
          // { "data": "status_post" },
          // { "data": "jenis_post" },
          // { "data": "published_at" },
      ],        
  });  

  //Add event listener for opening and closing details
  $('#table-status-permohonan tbody').on('click', 'button.details-data', function () {
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

  $('#table-status-permohonan tbody').on('click', '.hard-delete-confirm', function (event) {
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

  $('#table-status-permohonan tbody').on('click', '.soft-delete-confirm', function (event) {
      event.preventDefault();
      const url = $(this).attr('href');
      swal({
          title: 'Apakah anda yakin.?',
          text: 'Data ini akan dihapus.',
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

