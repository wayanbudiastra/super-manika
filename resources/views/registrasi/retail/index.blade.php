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
                            <td><a title="Edit Registrasi Retail" href="{{url('/registrasi_retail/'.$id.'/edit')}}" class="btn btn-warning btn-xs"><i class="fa fa-book"></i></a>
                                 <button title="Cencel Registrasi Retail" class="btn btn-danger btn-xs cencel"  data-id="{{$k->id}}">
                                  <i class="fa fa-trash"></i></button>
                            </td>
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


       
<!-- TES -->


@endsection

@section('js')
<script>
$(document).ready(function() {
      $('#basic-datatables').DataTable({
      });

      $(document).on('click', '.cencel', function (event) {
                        event.preventDefault();
                        var $this = $(this);
                        var id = $this.data('id');
                        console.log(id);
                 swal({
                  title: 'Apakah Anda Yakin Melajutkan proses?',
                  text: "Registrasi akan di batalkan!",
                  type: 'warning',
                  buttons:{
                  confirm: {
                          text : 'Yes, Lanjutkan!',
                          className : 'btn btn-success'
                          },
                  cancel: {
                          visible: true,
                          className: 'btn btn-danger'
                         }
                         }
                 }).then((willDelete)=>{
                      if (willDelete) {
                           $.ajax({
                            url: '{!!  url('/'); !!}'+'/cencel-registrasi-retail/'+ id,
                            data: {},
                            type: 'GET',
                            success: function (response) {
                               swal(
                                      'Proses berhasil!',
                                      'success')
                                           console.log(response);
                                            //location.reload();  
                                            window.location = '{!!  url('/'); !!}'+'/registrasi_retail/list';

                                        },
                              error: function (response) {
                                          var json_data = response;
                                          console.log(json_data);

                                            swal(
                                                'Terjadi Kesalahan!',
                                                'Silahkan coba lagi',
                                                    'error'
                                                )
                              }
                     
                  });
                }
            });
      });
    
    });
</script>
@endsection