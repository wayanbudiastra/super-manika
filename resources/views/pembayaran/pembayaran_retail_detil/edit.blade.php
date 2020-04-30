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
                            <a href="{{url('/pembayaran_retail')}}">Pembayaran Retail</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/pembayaran_retail_detil')}}">{{$subtitle}}</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Registrasi Pasien</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-6">
                                {{csrf_field()}}
                                        @php
                                                 $type_pasien ="";
                                                 $nama_pasien ="";
                                                 $tgl_lahir = "";
                                        @endphp
                                        @php
                                        if($data->registrasi_retail->jenis_registrasi_retail_id=='umum'){
                                            $type_pasien = 'umum';
                                            $nama_pasien = 'umum';
                                            $tgl_lahir = "-";
                                        }else{
                                            $type_pasien = 'pasien';
                                            $nama_pasien = info_pasien_nama($data->registrasi_retail->pasien_id);
                                            $tgl_lahir = tgl_indo(info_pasien_tgl_lahir($data->registrasi_retail->pasien_id));
                                        }
                                        @endphp
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Type Registrasi</label>
                                        <input type="text" class="form-control" id="namaDepan"
                                               placeholder="Nama Lengkap" value="{{$type_pasien}}"
                                               required="required" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nama Pasien</label>
                                        <input type="text" class="form-control" id="namaDepan"
                                               placeholder="Nama Lengkap" value="{{$nama_pasien}}"
                                               required="required" readonly="readonly">
                                    </div>

                                   

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tanggal Lahir</label>
                                        <input type="text"
                                               class="form-control"
                                               data-language='en'
                                               data-position="top left"
                                               value="{{$tgl_lahir}}"
                                               required="required"
                                               readonly="readonly"
                                        />
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">No Regs</label>
                                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode"
                                               value=" {{$data->registrasi_retail->no_registrasi}}" readonly="readonly">
                                    </div>

                                    
                                   
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Keterangan</label>
                                        <textarea name="keterangan" class="form-control" id="keterangan"
                                                  readonly="readonly" cols="30"
                                                  rows="3">{{$data->registrasi_retail->keterangan}}</textarea>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                               <span id="addtindakan"></span>
                                <span id="additem"></span>
                                <?php $id = Crypt::encrypt($data->id); ?>
                                <a class="btn btn-warning btn-round" href="{{url('/pembayaran_retail_detil/printprev/'.$id)}}" target="_BLANK">
                                    <i class="fa fa-print"></i>
                                    Print Preview
                                </a>

                                <span id="cekposting"></span>
                                <h1>  Total Bill: <b><span id="subtotal"></span></b></h1>
                               
                            </div>
                        </div>

                        <div class="table-responsive" id="reloadpaginate">
                            @include('pembayaran.pembayaran_retail_detil.paginate')
                        </div>


                    </div>
                </div>
            </div>
        </div>

     
        <div id="modaladdtransaksi"></div>
        <div id="loadmodaltembyaddtransaksi"></div>
        <div id="modaladdtransaksitindakan"></div>
        <div id="loadmodalTindakanbyaddtransaksi"></div>
        
        
        @endsection

        @section('js')

            <script type="text/javascript">
                $(document).ready(function () {
                    //function show modal create
                    $(document).off('click', '.loadmodaltransaksicreate');
                    $(document).off('click', '.loadmodaltransaksitindakancreate');
                    $(document).on('click', '#loadmodaltransaksicreate', function (event) {
                        event.preventDefault();
                        $("#loadmodaltransaksicreate").prop('disabled', true);
                        $('#modaladdtransaksi').load('{!!  url('/'); !!}'+"/load-modal-data-create-transaksi-retail/" + '{!! Crypt::encrypt($data->id) !!}');
                    })
                    $(document).on('click', '#loadmodaltransaksitindakancreate', function (event) {
                        event.preventDefault();
                        $("#loadmodaltransaksitindakancreate").prop('disabled', true);
                        $('#modaladdtransaksitindakan').load('{!!  url('/'); !!}'+"/load-modal-data-create-transaksi-tindakan-retail/" + '{!! Crypt::encrypt($data->id) !!}');
                    })
                    $(document).on('click', '.delete', function (event) {
                        event.preventDefault();
                        var $this = $(this);
                        var id = $this.data('id');
                        swal({
                            title: 'Apakah Anda Yakin ?',
                            text: "Hapus Data Tersebut!",
                            type: 'warning',
                            buttons: {
                                confirm: {
                                    text: 'Ya, Hapus!',
                                    className: 'btn btn-success'
                                },
                                cancel: {
                                    visible: true,
                                    className: 'btn btn-danger'
                                }
                            }
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                    $.ajax({
                                        url: '{!!  url('/'); !!}'+'/hapus-pembayaran-detail-retail/' + id,
                                        data: {
                                            "id": id,
                                            "_token": $("input[name='_token']").val(),
                                        },
                                        type: 'post',
                                        success: function (response) {

                                            swal(
                                                'Hapus!',
                                                'Data Berhasil Dihapus.',
                                                'success'
                                            )
                                            $('#reloadpaginate').load('{!!  url('/'); !!}'+"/pembayaran_retail_detil/" + '{!! Crypt::encrypt($data->id) !!}' + "/edit");

                                        },
                                        error: function (response) {
                                            swal(
                                                'Hapus!',
                                                'Data Gagal Hapus.',
                                                    'error'
                                                )
},

                                    })
                                }
                            })

                    })
                    $(document).on('click', '#posting', function (event) {
                        event.preventDefault();
                        var $this = $(this);
                        var id = $this.data('id');
                        var jenis = $this.data('jenis');
                        var value = $this.data('value');
                        swal({
                            title: 'Apakah Anda Yakin ?',
                            text: jenis+" Data Tersebut!",
                            type: 'warning',
                            buttons: {
                                confirm: {
                                    text: 'Ya, '+jenis+'!',
                                    className: 'btn btn-success'
                                },
                                cancel: {
                                    visible: true,
                                    className: 'btn btn-danger'
                                }
                            }
                        })
                            .then((willDelete) => {
                                if (willDelete) {
                                    $.ajax({
                                        url: '{!!  url('/'); !!}'+'/posting-pembayaran-detail-retail/' + id,
                                        data: {
                                            "id": id,
                                            "value": value,
                                            "_token": $("input[name='_token']").val(),
                                        },
                                        type: 'post',
                                        success: function (response) {

                                            swal(
                                                'Posting Bill!',
                                                'Data Berhasil '+jenis+'.',
                                                'success'
                                            )
                                            //$('#reloadpaginate').load('{!!  url('/'); !!}'+"/pembayaran_detil/" + '{!! Crypt::encrypt($data->id) !!}' + "/edit");
                                            window.location = '{!!  url('/'); !!}'+'/pembayaran/show';
                                        },
                                        error: function (response) {

                                            swal(
                                                jenis+'!',
                                                'Data Gagal '+jenis+'.',
                                                'error'
                                            )
},
                                    })
                                }
                            })

                    })
                })
                $(".date").datepicker({
                    autoclose: true,
                    locale: 'no',
                    format: 'yyyy-mm-dd',
                })

                

                $('#basic-datatables').DataTable({});

                function validate(evt) {
                    var theEvent = evt || window.event;

                    // Handle paste
                    if (theEvent.type === 'paste') {
                        key = event.clipboardData.getData('text/plain');
                    } else {
                        // Handle key press
                        var key = theEvent.keyCode || theEvent.which;
                        key = String.fromCharCode(key);
                    }
                    var regex = /[0-9]|\./;
                    if (!regex.test(key)) {
                        theEvent.returnValue = false;
                        if (theEvent.preventDefault) theEvent.preventDefault();
                    }
                }
            </script>
@endsection
