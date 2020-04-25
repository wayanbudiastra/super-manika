@extends('layouts.master')
@section('content')
<div class="main-panel">
      <div class="content">
        <div class="page-inner">
          <div class="page-header">
            <h4 class="page-title">{{$title}}</h4>
            <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="#">
                  <i class="flaticon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href="{{url('/registrasi')}}">registrasi</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href="{{url('/registrasi')}}">{{$subtitle}}</a>

              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
             
               <!-- <a href="{{url('/pasien/cari')}}" class="btn btn-danger btn-round ml-1"> <i class="fa fa-search"></i>cari data pasien</a> -->
            </ul>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                  <h4 class="card-title">{{$subtitle}}</h4>
              
                </div>
                </div>
                <div class="card-body">
                    @if(session('sukses'))
                 <div class="alert alert-success" role="alert">
                {{session('sukses')}}
                </div>  
                 @endif
                  @if(session('gagal'))
                 <div class="alert alert-danger" role="alert">
                {{session('gagal')}}
                </div>  
                 @endif
                  <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover" >
                      <thead>
                       <tr>
                        <th>No</th>
                        <th>No Registrasi</th>
                        <th>Type Pasien</th>
                        <th>Nama Pasien</th>
                        <th width="18%">Tgl Lahir</th>
                        <!-- <th>Usia</th> -->
                        <th>Keterangan</th>
                        <th>Aksi</th>
                        </tr>
                      </thead>
                     
                      <tbody>
                        @foreach($data as $k)
                            @php
                                $type_pasien ="";
                                $nama_pasien ="";
                                $tgl_lahir = "";
                            @endphp

                            <?php $id = Crypt::encrypt($k->id); ?>
                            @php
                                if($k->jenis_registrasi_retail_id=='umum'){
                                    $type_pasien = 'umum';
                                    $nama_pasien = 'umum';
                                    $tgl_lahir = "-";
                                }else{
                                    $type_pasien = 'pasien';
                                     $nama_pasien = info_pasien_nama($k->pasien_id);
                                    $tgl_lahir = tgl_indo(info_pasien_tgl_lahir($k->pasien_id));
                                }
                            @endphp
                            <tr>
                            <td>{{$no=$no+1}}</td>
                            <td>{{$k->no_registrasi}}</a></td>
                            <td>{{$type_pasien}}</a></td>
                            <td>{{$nama_pasien}}</td>
                            <td>{{$tgl_lahir}}</td>
                            <!-- <td>{{hitung_usia($k->tgl_lahir)}}</td> -->
                            <td>{{$k->keterangan}}</td>
                            <td><a href="{{url('/registrasi_retail/'.$id.'/edit')}}" class="btn btn-warning btn-xs"> <i class="flaticon-right-arrow"></i>Edit</a></td>
                            </tr>
                            
                            @endforeach

                      </tbody>
                    </table>
                    
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
</div>


        <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header no-bd">
                          <h5 class="modal-title">
                            <span class="fw-light">
                             {{$title}}
                            </span>
                          </h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                         
                          <form action="{{url('/registrasi/cari')}}" method="POST" enctype="multipart/form-data">
                             {{csrf_field()}}
                            <div class="row">
                              <div class="col-md-10 pr-0">
                                <div class="form-group form-group-default">
                                  <label>Nama Pasien/ No CM</label>
                                  <input name="cari" type="text" class="form-control" placeholder="cari nama / no CM">
                                </div>
                              </div>
                            </div>
                         
                        </div>
                        <div class="modal-footer no-bd">
                          <button type="submit"  class="btn btn-primary">Cari</button>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        </div>
                      </div>
                       </form>
                    </div>
                  </div>
<!-- TES -->


@endsection

@section('js')
<script>
$(document).ready(function() {
      $('#basic-datatables').DataTable({
      });

// $(document).ready(function() {
//     $('#datatable').DataTable({
//         processing:true,
//         serverside:true,
//         ajax:"{{route('ajax.get.data.pasien')}}",
//         columns:[
//             {data:'nocm',name:'nocm'},
//             {data:'nama',name:'nama'},
//             {data:'tanggal_indo',name:'tanggal_indo'},
//             {data:'alamat',name:'alamat'},
//             {data:'pekerjaan',name:'pekerjaan'}
//         ]
//     })
// });

  $('#multi-filter-select').DataTable( {
        "pageLength": 5,
        initComplete: function () {
          this.api().columns().every( function () {
            var column = this;
            var select = $('<select class="form-control"><option value=""></option></select>')
            .appendTo( $(column.footer()).empty() )
            .on( 'change', function () {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
                );

              column
              .search( val ? '^'+val+'$' : '', true, false )
              .draw();
            } );

            column.data().unique().sort().each( function ( d, j ) {
              select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
          } );
        }
      });

      // Add Row
      $('#add-row').DataTable({
        "pageLength": 5,
      });

      var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

      $('#addRowButton').click(function() {
        $('#add-row').dataTable().fnAddData([
          $("#addName").val(),
          $("#addPosition").val(),
          $("#addOffice").val(),
          action
          ]);
        $('#addRowModal').modal('hide');

      });
    });
</script>
@endsection