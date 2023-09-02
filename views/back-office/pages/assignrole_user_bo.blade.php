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
                  <th >Nama Pengguna</th>
                  <th >Role</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td></td>
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

@section('modal-status')
<div class="modal fade" tabindex="-1" role="dialog" id="statusRoleUser">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Role User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" action="" enctype="multipart/form-data" class="" id="modal-assign-role">
        <div class="modal-body">
            @csrf
            <div class="form-group">
              <label>Nama : <span id="nama_pengguna">Status Permintaan</span></label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-marker"></i>
                  </div>
                </div>
                <select class="form-control" id="role_user" name="role_user">
                  @foreach($roles as $datarole) 
                  <option value="{{ $datarole->name }}">{{ $datarole->name }}</option>
                  @endforeach
                </select>
                <input type="hidden" class="form-control" value="" name="iduser" id="iduser">
                <input type="hidden" class="form-control" value="" name="idrole" id="idrole">
                <input type="hidden" class="form-control" value="" name="namerolebefore" id="namerolebefore">
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
      ajax: '{{ url('bo/json/role-permission-user/assign-role-user') }}',
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
              // "width": "140px",
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
              "searchable": false,
              "width": "100px",
              "className": 'dt-center cell-button-update-assign-role-user',
              "orderable": false,
          },                                                          
      ],        
      columns: [
          { "data": "" },
          { "data": "name" },
          { "data": "role_name" },
          { "data": "update" },
          // { "data": "updated_at" },
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

  //Add event listener for change status
  $('#table_roleuser tbody').on('click', 'td.cell-button-update-assign-role-user', function(e) {
      e.preventDefault();
      var data = table.row( $(this).parents('tr') ).data(); 
      console.log(data);
      $("#nama_pengguna").html(data.name);
      $("#iduser").val(data.iduser);
      $("#idrole").val(data.idrole);
      $("#namerolebefore").val(data.rolename[0].name);
      $("select#role_user").val(data.rolename[0].name);
      $("#modal-assign-role").attr('action', data.route_update_role);    
  });    

});  
  
</script>
@endpush

