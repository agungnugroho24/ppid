@extends('front-office.layouts.master')

@section('title', 'Halaman Progres Pengajuan Keberatan Atas Permohonan Informasi')

@push('app-styles')
  <x-css-back-office/>
@endpush

@section('navbar')
  <x-navbar-home/>
@endsection

@section('mainsection')
    <x-header-home-area/>

    <!-- ======= Services Section ======= -->
    <div id="services" class="services-area area-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">{{ __('Progres Pengajuan Keberatan Atas Permohonan Informasi') }}</div>
                        @include('sweetalert::alert')
                        
                        <div class="card-body">
                          <div class="table-responsive">
                            <table class="table table-striped" id="table-data-permintaan-informasi">
                              <thead>
                                <tr>
                                  <th class="text-center details-data"></th>
                                  <th class="text-center">No.</th>
                                  <th>No. Pendaftaran</th>
                                  <th>Tujuan Penggunaan Informasi</th>
                                  <th>Alasan Keberatan</th>
                                  <th>Tanggal Pengajuan</th>
                                  <th>Status</th>
                                  <th>Keterangan</th>
                                  <th>Survey Layanan</th>
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
                                  <td><a href="#" class="btn btn-secondary"></a></td>
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
    </div><!-- End Services Section -->

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

function toList(str) {
  var txt ="";
  txt = txt + "<li>" + str + "</li>";
  return txt;
}

$(document).ready(function() {
  var table = $('#table-data-permintaan-informasi').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{{ url('bo/json/pengajuan-keberatan-progres') }}',
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
              "className": 'dt-center',
              render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
              }
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
              "searchable": true,
              // render: function(data){
              //   var char = data.includes("#");
              //   if(char){
              //     var txt = "";
              //     // var str = data.split("#").join("<li>"+this+"/li>");
              //     var str = data.split("#");
              //     str.forEach(toList);
              //     return txt;
              //   }else{
              //     return "<li>"+data+"</li>";
              //   }
              // }
          },         
          {
              "targets": [ 5 ], 
              "visible": true,
              "searchable": true,
              render: function(data){
                    return data;
              }
          },         
          {
              "targets": [ 6 ], 
              "visible": true,
              "searchable": true,
              "className": 'dt-center cell-statuspermintaan small',
              "render": function(data){
                  var statuspermintaan = "Permohonan&nbsp;"+data;
                  if(data == "Menunggu approval"){
                    var textdata = data.split(" ").join('&nbsp;');
                    return textdata;
                  }
                  if(data == "Permohonan diterima"){
                    return data;
                  }                  
                  // else if(data == "Diterima"){
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
              },
          },  
          {
              "targets": [ 7 ], 
              "visible": true,
              "searchable": true,
              "render": function(data, row, meta){
                var alasanPenolakan = data.alasan_penolakan;
                var rowStatus = data.nama_status;
                var row;
                  if(alasanPenolakan){
                    row = '<div class="font-weight-bold mt-2">Alasan Penolakan : '+alasanPenolakan+'</div>';
                  }else{
                    row = '';
                  }
                  return rowStatus+row;
              },              
          }, 
          {
              "targets": [ 8 ], 
              "visible": true,
              "searchable": true,
              "className": 'dt-left',
          },                                                           
      ],        
      columns: [
          { "data": "" },
          { "data": "" },
          { "data": "nomor_pendaftaran" },
          { "data": "tujuan_penggunaaninformasi" },
          { "data": "alasan_keberatan" },
          { "data": "created_at" },
          { "data": "status_permintaan" },
          { "data": function(data){
              return data;
            }
          },
          { "data": function(data){
              return data.link_survey;
            }
          },           
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
  $('#table-data-permintaan-informasi tbody').on('click', 'button.details-data', function () {
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
