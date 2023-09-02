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
    <a href="{{route('post-content-create')}}" class="btn btn-primary">Tambah Baru</a>
  </div>  
  <!-- <div class="section-header-breadcrumb"> -->
    <!-- <div class="breadcrumb-item active"><a href="#">Dashboard</a></div> -->
    <!-- <div class="breadcrumb-item"><a href="#">Modules</a></div> -->
    <!-- <div class="breadcrumb-item">DataTables</div> -->
  <!-- </div> -->
</div>

<div class="section-body">
  <h2 class="section-title">Posts Content</h2>
  <p class="section-lead">
    You can manage all posts, such as editing, deleting and more.
  </p>

  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4></h4>
        </div>
        <div class="card-body">
<!--           if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
              <strong> $message }}</strong>
            </div>
          endif

          if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong> $message }}</strong>
            </div>
          endif  -->          
          <div class="table-responsive">
            <table class="table table-striped" id="table-post_content">
              <thead>
                <tr>
                  <th class="text-center details-data" rowspan="2">#</th>
                  <th rowspan="2">Judul</th>
                  <th rowspan="2">Penulis</th>
                  <th rowspan="2">Kategori</th>
                  <th rowspan="2">Status Post</th>
                  <th rowspan="2">Jenis Post</th>
                  <th rowspan="2">Dipublish Pada</th>
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
                  <td></td>
                  <td class="align-middle"></td>
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
              '<tr style="font-weight:bold;">'+
                  '<td width="15%">&nbsp;Soft Delete Pada Tanggal</td>'+
                  '<td width="2%">:</td>'+
                  '<td>'+data.deleted_at+'</td>'+
              '</tr>'+   
              '<tr style="font-weight:bold;">'+
                  '<td width="15%">&nbsp;Konten</td>'+
                  '<td width="2%">:</td>'+
                  '<td>'+data.konten+'</td>'+
              '</tr>'+                                                                                 
          '</table>';

}  

$(document).ready(function() {
  var table = $('#table-post_content').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ url('bo/json/post-content') }}',
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
          { "data": "kategori" },
          { "data": "status_post" },
          { "data": "jenis_post" },
          { "data": "published_at" },
          { "data": "update" },
          { "data": "delete" },
      ],        
  });  

  //Add event listener for opening and closing details
  $('#table-post_content tbody').on('click', 'button.details-data', function () {
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
});  
  
</script>
@endpush

