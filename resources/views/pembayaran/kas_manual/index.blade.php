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
                                    <button class="btn btn-primary btn-round ml-auto" data-toggle="modal"
                                            data-target="#addRowModal">
                                        <i class="fa fa-plus"></i>
                                        Add Row
                                    </button>

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
                                <div class="table-responsive">
                                    <table id="basic-datatables" class="display table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Open</th>
                                            <th>Saldo Awal</th>
                                            <th>Keterangan</th>
                                            <th>Aktif</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($data as $k)
                                            <tr>
                                                <td>{{$no=$no+1}}</td>
                                                <td>{{tgl_indo($k->tgl_open)}}</td>
                                                <td>{{rupiah($k->kas_awal)}}</td>
                                                <td>{{$k->keterangan}}</td>
                                                
                                                <td>{!!  ($k->aktif == "Y") ? '<span class="btn btn-success btn-round btn-xs">Ya</span>' : ('<span class="btn btn-danger btn-round btn-xs">Tidak</span>')!!}</td>
                                                <td>
                                                    <center>
                                                        @if($k->aktif=="Y")
                                                        <a href="{{url('/kas/'.$k->id.'/edit')}}"
                                                               class="btn btn-warning btn-xs">Update</a>
                                                        @endif</center>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                <!-- <center>{{ $data->links() }}</center> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content modal-lg">
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

                        <form action="{{url('/kas_manual')}}" method="POST" enctype="multipart/form-data" id="formManual_kas">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                        <label>Kas Masuk</label>
                                        <label class="radio-inline"><input type="radio" name="transaksi" value="Masuk" id="masuk" onclick="updatekas_masuk()">Kas Masuk</label>
                                        <label class="radio-inline"><input type="radio" name="transaksi" value="Keluar" id="keluar" onclick="updatekas_keluar()">Kas Keluar</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                        <label>Kas Masuk</label>
                                        <input name="kas_masuk" type="text" class="form-control"
                                               placeholder="Kas Masuk" id="kas_masuk">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                        <label>Kas Keluar</label>
                                        <input name="kas_keluar" type="text" class="form-control"
                                               placeholder="Kas Keluar" id="kas_keluar">
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group form-group-default">
                                        <label>Keterangan kas</label>
                                        <input name="keterangan" type="text" class="form-control"
                                               placeholder="keterangan kas" required>
                                    </div>
                                </div>
                                
                            </div>

                    </div>
                    <div class="modal-footer no-bd">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
                </form>
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


                    $('#basic-datatables').DataTable({});

                    $('#multi-filter-select').DataTable({
                        "pageLength": 5,
                        initComplete: function () {
                            this.api().columns().every(function () {
                                var column = this;
                                var select = $('<select class="form-control"><option value=""></option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                        );

                                        column
                                            .search(val ? '^' + val + '$' : '', true, false)
                                            .draw();
                                    });

                                column.data().unique().sort().each(function (d, j) {
                                    select.append('<option value="' + d + '">' + d + '</option>')
                                });
                            });
                        }
                    });

                    // Add Row
                    $('#add-row').DataTable({
                        "pageLength": 5,
                    });

                    var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

                    $('#addRowButton').click(function () {
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

            <script>
                function updatekas_masuk(){
                var pt1 = document.getElementById("masuk").value;
               // document.getElementById("formManual_kas").reset();
                    if(pt1 == "Masuk") {
                        document.getElementById("kas_keluar").readOnly = true;
                        document.getElementById("kas_masuk").readOnly = false;
                        document.getElementById("kas_keluar").value = 0;
                        document.getElementById("kas_masuk").focus();
                    }else{
                        document.getElementById("kas_masuk").readOnly = true;
                        document.getElementById("kas_keluar").readOnly = false;
                        document.getElementById("kas_masuk").value = 0;
                        document.getElementById("kas_keluar").focus();

                    }
                }

                function updatekas_keluar(){
                var pt1 = document.getElementById("keluar").value;
               // document.getElementById("formManual_kas").reset();
                    if(pt1 == "Keluar") {
                        document.getElementById("kas_masuk").value = 0;
                        document.getElementById("kas_masuk").readOnly = true;
                        document.getElementById("kas_keluar").readOnly = false;
                        document.getElementById("kas_keluar").focus();
                    }else{
                        document.getElementById("kas_keluar").readOnly = true;
                        document.getElementById("kas_masuk").readOnly = false;
                        document.getElementById("kas_keluar").value = 0;
                        document.getElementById("kas_masuk").focus();

                    }
                }
            </script>
@endsection