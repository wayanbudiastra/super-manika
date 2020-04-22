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
                            <a href="#">Pemayaran</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">{{$subtitle}}</a>
                        </li>
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
                                        {!! session('gagal') !!}
                                    </div>
                                @endif
                                
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                      <li class="active nav-item"><a href="#tab_1" data-toggle="tab">Rawat Jalan</a></li>
                                      <li class="separator">
                                        <i class="flaticon-right-arrow"></i>
                                      </li>
                                      <li class="nav-item"><a href="#tab_2" data-toggle="tab">Retail</a></li>
                                      <li class="separator">
                                        <i class="flaticon-right-arrow"></i>
                                      </li>
                                      <li class="nav-item"><a href="#tab_3" data-toggle="tab">Kas Manual</a></li>
                                      
                                    </ul>
                                    <div class="tab-content">


                                        <div class="tab-pane active" id="tab_1">
                                            @include('pembayaran.kas_closing.pane1')
                                        </div>


                                        <div class="tab-pane" id="tab_2">
                                            @include('pembayaran.kas_closing.pane2')
                                           
                                        </div>

                                        <div class="tab-pane" id="tab_3">
                                            @include('pembayaran.kas_closing.pane3')
                                           
                                        </div>


                                    </div>
                                </div>
                                <hr>
                                <div class="text-right">
                                <h3>
                                <table class="table" border="0">
                                    <tr>
                                        <td>Kas Awal</td>
                                        <td width="15%">{{rupiah($kas->kas_awal)}}</td>
                                    </tr>
                                     <tr>
                                        <td>Total Pembayaran</td>
                                        <td>{{rupiah($total_pembayaran)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Retail</td>
                                        <td>-</td>
                                    </tr>
                                    <tr>
                                        <td>Total Manual Kas</td>
                                        <td>{{rupiah($total_kasManual)}}</td>
                                    </tr>

                                    
                                    <tr>
                                        @php
                                            $kas_akhir = $kas->kas_awal + $total_pembayaran + $total_kasManual;
                                        @endphp
                                        <td>Kas Akhir</td>
                                        <td>{{rupiah($kas_akhir)}}</td>
                                    </tr>
                                    <tr>
                                    <td colspan="2"> <button title="Simpan Closing Pembayaran" class="btn btn-success lanjut-closing" data-id="{{$kas->id}}">
                                    <i class="fa fa-save"></i>Simpan</button></td>
        
                                    </tr>
                                    </table>
                                    </h3>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


       
        <!-- TES -->

        <!-- </div> -->
        <!--Modal -->

        @endsection

        @section('js')
            <script>
                $(function () {
                    $("#exstdate").datepicker({
                        language: 'en',
                        autoclose: true,
                        todayHighlight: true,
                        weekStart: 1,
                        locale: 'en',
                        dateFormat: 'dd-mm-yyyy'
                    });
                });
                $(document).ready(function () {

                     $(document).on('click', '.lanjut-closing', function (event) {
                        event.preventDefault();
                        var $this = $(this);
                        var id = $this.data('id');

                        console.log(id);


                                swal({
                                title: 'Apakah Anda Yakin Melajutkan Proses?',
                                text: "Kas akan di closing - Transaksi tidak dapat di rubah!",
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
                                }).then((willDelete) => {
                                    if (willDelete) {
                                        $.ajax({
                                        url: '{!!  url('/'); !!}'+'/lanjut-closing/'+ id,
                                        data: {
                                        
                                         },
                                          type: 'GET',
                                          success: function (response) {
                                          swal(
                                                'Input berhasil!',
                                                'Closing kas Berhasil di simpan',
                                                'success'
                                            )
                                           
                                           window.location = '{!!  url('/'); !!}'+'/kas_closing';  
                                           //console.log(response);
                                        },
                                        error: function (response) {
                                          var json_data = response;
                                          console.log(json_data);
                                            swal(
                                                'Terjadi Kesalahan!',
                                                'Silahkan ulangi lagi!',
                                                    'error'
                                                )
                                            },
                                         })
                                    }
                                })
                  });
                   

                    // Add Row
                   

                  
                    
                });
            </script>
@endsection