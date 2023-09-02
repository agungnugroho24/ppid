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
    <!-- <a href="{{route('role-user-adm-create')}}" class="btn btn-primary">Tambah Baru</a> -->
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
            <table class="table table-striped" id="table_roleuser">
              <thead>
                <tr>
                  <th class="text-center details-data"></th>
                  <th >Nama Role</th>
                  <th >Keterangan Role</th>
                  <th >Memiliki Permission</th>
                  <th class="text-center">Action</th>
                  <!-- <th rowspan="2">Kategori</th> -->
                  <!-- <th rowspan="2">Kategori</th> -->
                  <!-- <th rowspan="2">Status Post</th> -->
                  <!-- <th rowspan="2">Dipublish Pada</th> -->
                </tr>
                <!-- <tr> -->
                    <!-- <th class="text-center">Publish</th> -->
                    <!-- <th class="text-center">Update</th> -->
                    <!-- <th class="text-center">Delete</th> -->
                <!-- </tr>                 -->
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <!-- <td class="align-middle"></td> -->
                  <!-- <td><div class="badge badge-success"></div></td> -->
                  <!-- <td></td> -->
                  <!-- <td></td> -->
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
              // '<tr style="font-weight:bold;">'+
              //     '<td width="15%">&nbsp;Dibuat Pada Tanggal</td>'+
              //     '<td width="2%">:</td>'+
              //     '<td>'+data.created_at+'</td>'+
              // '</tr>'+
              // '<tr style="font-weight:bold;">'+
              //     '<td width="15%">&nbsp;Diperbarui Pada Tanggal</td>'+
              //     '<td width="2%">:</td>'+
              //     '<td>'+data.updated_at+'</td>'+
              // '</tr>'+                                                                                  
          '</table>';

}  

$(document).ready(function() {
  var table = $('#table_roleuser').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ url('bo/json/role-permission-user/role-user') }}',
      columnDefs: [
          {
              "targets": [ 0 ],
              "data": null,
              "orderable": false,
              "width": "50px",
              "className": 'dt-center',
              "defaultContent": "<button class='details-data' title='data-detail'></button>",
          },
          {
              "targets": [ 1 ], 
              "visible": true,
              "width": "140px",
              "searchable": true
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
              "targets": [ -1 ], 
              "visible": true,
              "searchable": false,
              "width": "50px",
              "className": 'dt-center cell-button-update',
              "orderable": false,
          }, 
          // {
          //     "targets": [ -3 ], 
          //     "visible": true,
          //     "searchable": false,
          //     "width": "50px",
          //     "className": 'dt-center cell-button-publish',
          //     "orderable": false,
          // },                         
          // {
          //     "targets": [ -1 ], 
          //     "visible": true,
          //     "searchable": false,
          //     "width": "80px",
          //     "className": 'dt-center cell-button-delete',
          //     "orderable": false,
          // },                                                            
      ],        
      columns: [
          { "data": "" },
          { "data": "rolename" },
          { "data": "keterangan" },
          { "data": "permission_name" },
          { "data": "update" },
          // { "data": "guard_name" },
          // { "data": "created_at" },
      ],        
  });

  //Create title attribute for cell cell-action-button
  $('#table_roleuser tbody').on('mouseover','td.cell-button-publish',function(){
    $('[data-toggle="tooltip"]').tooltip();
  }); 

  $('#table_roleuser tbody').on('mouseover','td.cell-button-update',function(){
    $('[data-toggle="tooltip"]').tooltip();
  }); 

  $('#table_roleuser tbody').on('mouseover','td.cell-button-delete',function(){
    $('[data-toggle="tooltip"]').tooltip();
  });       

  //Add event listener for opening and closing details
  $('#table_roleuser tbody').on('click', 'button.details-data', function () {
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

  $('#table_roleuser tbody').on('click', '.hard-delete-confirm', function (event) {
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

  $('#table_roleuser tbody').on('click', '.soft-delete-confirm', function (event) {
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

