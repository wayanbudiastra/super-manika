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
                            <a href="#">Manajemen</a>
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

                                <form action="{{url('report/pendapatan/get_data')}}" method="POST" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="row mt-5">
                                        <div class="col-md-6">
                                            <label>Tanggal Mulai</label>
                                            <div class="form-group form-group-default">
                                                <input type="text" 
                                                class="datepicker-here form-control" 
                                                data-language='en'
                                                data-position="top left"
                                                name="tgl_mulai"
                                                required="required"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Tanggal Selesai</label>
                                            <div class="form-group form-group-default">
                                                <input type="text" 
                                                    class="datepicker-here form-control" 
                                                    data-language='en'
                                                    data-position="top left"
                                                    name="tgl_selesai"
                                                    required="required"
                                                    />
                                            </div>
                                        </div>
                                    </div>
        
                            </div>
                            <div class="modal-footer mt-2">

                                <button type="submit" class="btn btn-primary btn-sm btn-round ml-auto">
                                    <i class="fa fa-print"></i>
                                        Get Data
                                </button>

                            </form>
                            <form action="{{url('report/pendapatan/pdf')}}" method="POST" target="_Blank">
                                {{csrf_field()}}
                                <input type="hidden" name="tgl_mulai" value="{{$tgl_mulai}}">
                                <input type="hidden" name="tgl_selesai" value="{{$tgl_selesai}}">
                                    <button type="submit" class="btn btn-danger btn-sm btn-round ml-auto">
                                        <i class="fa fa-print"></i>
                                            Cetak PDF
                                    </button>
                            </form>
                                
                            <form action="{{url('report/pendapatan/excel')}}" method="POST" target="_Blank">
                                {{csrf_field()}}
                                <input type="hidden" name="tgl_mulai" value="{{$tgl_mulai}}">
                                <input type="hidden" name="tgl_selesai" value="{{$tgl_selesai}}">
                                <button type="submit" class="btn btn-success btn-sm btn-round ml-1" id="cetak_excel">
                                    <i class="fa fa-plus"></i>
                                    Cetak EXCEL</button>
                            </form>
                            </div>
                        


                                <div class="table-responsive">
                                    <table id="basic-datatables" class="display table table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Invoice</th>
                                            <th>Transaksi</th>
                                            <th>Item</th>
                                            <th>Harga</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        <?php $no=0;?>
                                        @foreach($data as $k)
                                            <tr>
                                                <td>{{$no=$no+1}}</td>
                                                <td>{{$k->no_invoice}}</td>
                                                <td>{{$k->transaksi}}</td>
                                                <td>{{$k->nama_item}}</td>
                                                <td>{{$k->harga_jual}}</td>
                                                <td>{{$k->qty}}</td>
                                                <td>{{$k->subtotal}}</td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                {{-- <!-- <center>{{ $data->links() }}</center> --> --}}
                                </div>
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

        <script type="text/javascript">
            $(".date").datepicker({
            autoclose: true,
            locale: 'no',
            format: 'yyyy-mm-dd',
            })
        </script>
            <script>
                $(document).ready(function () {

                    $("#cetak_pdf").click(function (e) {
                        let form = new FormData($("#CetakData")[0]);
                        console.log(form);

                        $.ajax({
                            url: '{!!  url('/'); !!}'+'/report/pendapatan/pdf',
                            data: new FormData($("#CetakData")[0]),
                            dataType: 'json',
                            async: false,
                            type: 'post',
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                window.open('{!!  url('/'); !!}'+'report/pendapatan/pdf');
                            },
                            error: function (data) {
                                $("#errMsg").prop('hidden', false);
                                $('#ShowErrordata').html('');
                                $('.messagebox').show().addClass('alert-danger');
                                  var messages = jQuery.parseJSON(data.responseText);
                                  $('#ShowErrordata').html(messages.message);
                                }

                        });
                    
                    });


                    $("#cetak_excel").click(function (e) {
                        let form = new FormData($("#CetakData")[0]);
                        console.log('excel');
                    
                    });


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

           
@endsection