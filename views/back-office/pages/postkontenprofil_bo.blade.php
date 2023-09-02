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
    <a href="{{route('post-konten-profil-create')}}" class="btn btn-primary">Tambah Baru</a>
  </div>  
</div>

<div class="section-body">
  <p class="section-lead">
  </p>

  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4></h4>
        </div>
        <div class="card-body">
         
          <div class="table-responsive">
            <table class="table table-striped" id="table_post_kontenprofil">
              <thead>
                <tr>
                  <th class="text-center details-data" rowspan="2"></th>
                  <th rowspan="2">Judul</th>
                  <th rowspan="2">Penulis</th>
                  <th rowspan="2">Status Post</th>
                  <!-- <th rowspan="2">Kategori</th> -->
                  <!-- <th rowspan="2">Jenis Post</th> -->
                  <th rowspan="2">Dipublish Pada</th>
                  <th colspan="3" class="text-center">Action</th>
                </tr>
                <tr>
                    <th class="text-center">Publish</th>
                    <th class="text-center">Update</th>
                    <th class="text-center">Delete</th>
                </tr>                
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td class="align-middle"></td>
                  <td></td>
                  <!-- <td></td> -->
                  <!-- <td></td> -->
                  <td><div class="badge badge-success"></div></td>
                  <td></td>
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
              '<tr style="font-weight:bold;">'+
                  '<td width="15%">&nbsp;Soft Delete Pada Tanggal</td>'+
                  '<td width="2%">:</td>'+
                  '<td>'+data.deleted_at+'</td>'+
              '</tr>'+   
              '<tr>'+
                  '<td width="15%" style="font-weight:bold;">&nbsp;Konten</td>'+
                  '<td width="2%" style="font-weight:bold;">:</td>'+
                  '<td>'+data.isi_konten+'</td>'+
              '</tr>'+                                                                                 
          '</table>';

}  

$(document).ready(function() {
  var table = $('#table_post_kontenprofil').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ url('bo/json/post-konten-profil') }}',
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
              "width": "120px",
              "searchable": true
          },        
          {
              "targets": [ 2 ], 
              "visible": true,
              "width": "100px",
              "searchable": true
          },         
          {
              "targets": [ 3 ], 
              "visible": true,
              "searchable": true,
              "className": 'dt-justify',
              "render": function(data){
                  var status = data;
                  if(data){
                    return '<span style="font-weight:bold;color:#19a3d1;">Published</span>';
                  }else{
                    return '<span style="font-weight:bold;color:#d65c33;">Unpublished</span>';
                  }
              },
          },             
          {
              "targets": [ 4 ], 
              "visible": true,
              "searchable": true
          },         
          {
              "targets": [ -3 ], 
              "visible": true,
              "searchable": false,
              "className": 'dt-center',
              "orderable": false,
          },                         
          {
              "targets": [ -2 ], 
              "visible": true,
              "searchable": false,
              "className": 'dt-center',
              "orderable": false,
          }, 
          {
              "targets": [ -1 ], 
              "visible": true,
              "searchable": false,
              "className": 'dt-center',
              "orderable": false,
          },                                                            
      ],        
      columns: [
          { "data": "" },
          { "data": "judul" },
          { "data": "name" },
          { "data": "is_publish" },
          { "data": "published_at" },
          { "data": "publish" },
          { "data": "update" },
          { "data": "delete" },
      ],        
  });  

  //Add event listener for opening and closing details
  $('#table_post_kontenprofil tbody').on('click', 'button.details-data', function () {
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

  $('#table_post_kontenprofil tbody').on('click', '.hard-delete-confirm', function (event) {
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

  $('#table_post_kontenprofil tbody').on('click', '.soft-delete-confirm', function (event) {
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

