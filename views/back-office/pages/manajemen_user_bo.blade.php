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
    <!-- <a href="{{route('manajemen-user-adm')}}" class="btn btn-primary">Tambah Baru</a> -->
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
            <table class="table table-striped" id="table_post_informasipublik">
              <thead>
                <tr>
                  <th class="text-center details-data" rowspan="2"></th>
                  <th rowspan="2">Nama</th>
                  <th rowspan="2">Email</th>
                  <th rowspan="2">Jenis Pemohon</th>
                  <th rowspan="2">Jenis Identitas</th>
                  <th rowspan="2">No. Identitas</th>
                  <th rowspan="2">No. Ponsel</th>
                  <th rowspan="2">Status Active/Deactive</th>
                  <th colspan="2" class="text-center">Action</th>
                </tr>
                <tr>
                    <th class="text-center">Change Status User</th>
                    <th class="text-center">Delete</th>
                </tr>                
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="align-middle"></td>
                  <td></td>
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

@push('app-script')
<script>
function format(data) {
  return '<table cellpadding="10" cellspacing="0" width="100%" border="0" style="margin-left:0px;">'+
              // '<tr style="font-weight:bold;">'+
              //     '<td width="15%">&nbsp;Dibuat Pada Tanggal</td>'+
              //     '<td width="2%">:</td>'+
              //     '<td>'+data.created_at+'</td>'+
              // '</tr>'+                                                                                
          '</table>';

}  

$(document).ready(function() {
  var table = $('#table_post_informasipublik').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ url('bo/json/manajemen-user') }}",
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
              "searchable": true
          },         
          {
              "targets": [ 4 ], 
              "visible": true,
              "searchable": true,
              "className": 'dt-justify',
          }, 
          {
              "targets": [ 5 ], 
              "visible": true,
              "searchable": true,
          }, 
          {
              "targets": [ 6 ], 
              "visible": true,
              "searchable": true,
          }, 
          {
              "targets": [ 7 ], 
              "visible": true,
              "searchable": true,
              "className": 'dt-center',
              "render": function(data){
                  var status = data;
                  if(data){
                    return '<span style="font-size:14px;font-weight:bold;color:#40b240;">Active</span>';
                  }else{
                    return '<span style="font-size:14px;font-weight:bold;color:#d65c33;">Deactive</span>';
                  }
              },
          },                                             
          {
              "targets": [ -2 ], 
              "visible": true,
              "searchable": false,
              "width": "90px",
              "className": 'dt-center cell-button-update',
              "orderable": false,
          }, 
          {
              "targets": [ -1 ], 
              "visible": true,
              "searchable": false,
              "width": "80px",
              "className": 'dt-center cell-button-delete',
              "orderable": false,
          },                                                            
      ],        
      columns: [
          { "data": "" },
          { "data": "name" },
          { "data": "email" },
          { "data": "jenis_pemohon" },
          { "data": "jenis_identitas" },
          { "data": "nomor_identitas" },
          { "data": "nomor_ponsel" },
          { "data": "is_active" },
          { "data": "activate" },
          { "data": "delete" },
      ],        
  });

  //Create title attribute for cell cell-action-button
  $('#table_post_informasipublik tbody').on('mouseover','td.cell-button-publish',function(){
    $('[data-toggle="tooltip"]').tooltip();
  }); 

  $('#table_post_informasipublik tbody').on('mouseover','td.cell-button-update',function(){
    $('[data-toggle="tooltip"]').tooltip();
  }); 

  $('#table_post_informasipublik tbody').on('mouseover','td.cell-button-delete',function(){
    $('[data-toggle="tooltip"]').tooltip();
  });       

  //Add event listener for opening and closing details
  $('#table_post_informasipublik tbody').on('click', 'button.details-data', function () {
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

  $('#table_post_informasipublik tbody').on('click', '.hard-delete-confirm', function (event) {
      event.preventDefault();
      const url = $(this).attr('href');
      swal({
          title: 'Apakah anda yakin?',
          text: 'Data ini akan dihapus secara permanen !',
          icon: 'warning',
          buttons: ["Cancel", "Yes"],
      }).then(function(value) {
          if (value) {
              window.location.href = url;
          }
      });
  }); 

  $('#table_post_informasipublik tbody').on('click', '.soft-delete-confirm', function (event) {
      event.preventDefault();
      const url = $(this).attr('href');
      swal({
          title: 'Apakah anda yakin?',
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

