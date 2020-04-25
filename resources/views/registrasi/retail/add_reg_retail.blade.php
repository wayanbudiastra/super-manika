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
                <a href="{{url('/registrasi')}}">Registrasi</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href="{{url('/registrasi')}}">{{$subtitle}}</a>
              </li>
            </ul>
          </div>


           <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                  <h4 class="card-title">{{$title}}</h4>
                  
                </div>
                </div>
                <form action="{{url('/registrasi_retail')}}" class="form" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row">
                  <div class="col-md-6" >
                    <div class="form-group">
                     <label for="exampleInputEmail1">No Regs</label>
                     <input type="text" class="form-control" id="kode"  name="no_registrasi" placeholder="Kode" value=" {{max_noreg_retail()}}" readonly="readonly">
                    </div>


                    <div class="form-group">
                        <label for=""> Type Pasien</label>
                        <div class="form-check">
                        <input class="form-check-input radio1" type="radio" name="jenis_registrasi_retail_id" id="radio1" value="umum">
                        <label class="form-check-label" for="exampleRadios1">
                            Umum  
                        </label>
                        <label class="form-check-label" for="exampleRadios1">
                            -
                        </label>
                        <input class="form-check-input radio2" type="radio" name="jenis_registrasi_retail_id" id="radio2"  value="pasien">
                        <label class="form-check-label" for="exampleRadios2">
                            Pasien
                        </label>
                        </div>
                    </div>
                    <div class="form-group">
                     <label for="exampleInputEmail1">Pasien</label>
                     
                    <select class="form-control input-sm" name="pasien_id" id="id_pasien">
                    <option value=""></option>
                     </select>
                     
                    </div>
                
                 
               </div>  
                  
                  <div class="col-md-6">
        
                  <div class="form-group">
                  <label for="exampleInputEmail1">Keterangan</label>
                  <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="5"></textarea>
                  </div>
                  </div>
                  <div class="col-md-12">
                  <div class="form-group">
                  <a href="{{url('/registrasi_retail')}}"  class="btn btn-danger btn-xs">Close</a>
                  <button type="submit" class="btn btn-primary btn-xs">Save Reg</button>
                  </div>
                  </div>


                 
                </form>
                </div>
            </div>
           </div>
        </div>
      </div>
</div>

@endsection

@section('js')
<script type="text/javascript">

    $('#id_pasien').select2({placeholder: "Pilh Pasien...", width: '100%'});
     $(document).ready(function () {

             $(document).on('click','#radio1',function(){
                  $('#id_pasien').empty();
                  let op="<option value=''></option>";
                  let umum = "umum";
                  op+="<option value='"+ umum +"'>"+umum+"</option>";
                   $('#id_pasien').append(op);
                console.log('umum');
             });

              $(document).on('click','#radio2',function(){
                  $('#id_pasien').empty();
                 $.ajax({
                     type:'get',
                     url:"{{url('/ajax-get-pasien')}}",
                     data:{},
                    success:function(data){
                    let op="<option value=''></option>";
                    for(var i=0;i<data.length;i++){
                    op+="<option value='"+data[i].id+"'>"+data[i].nama+"  ("+data[i].tgl_lahir+")</option>";
                    }
                    $('#id_pasien').append(op);
                    },
                    error:function(){
                    console.log('error');
                    }
                 });
             });


    });
   

</script>
@endsection
