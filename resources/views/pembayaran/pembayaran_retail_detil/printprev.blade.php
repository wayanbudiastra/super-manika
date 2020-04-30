<!DOCTYPE html>
<html>
<head>
	<title>{{$title}}</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<!-- <link rel="stylesheet" href="{{asset('/assets/css/bootstrap.min.css')}}"> -->
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
		h5{
			font-size: 9pt;
		}
		h4{
			font-size: 12pt;
		}
	</style>
	<center>
		<h4>Preview Bill Sementara</h4>
		<br>
		
    </center>
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

	<table border="0">
		<tr>
			<td>Type Registrasi</td><td>: {{$type_pasien}}</td>
        </tr>
        <tr>
        <td>No regis</td><td>: {{$data->registrasi_retail->no_registrasi}}</td>
        </tr>
		<tr>
			<td>Nama pasien</td><td>: {{$nama_pasien}}</td>
		</tr>
		<tr>
			<td>Tanggal Lahir</td><td>: {{$tgl_lahir}}</td>
		</tr>
		
		
		
	</table>

	<table class='table table-bordered'>
		<thead>
		<tr>
		<th>No</th>
        <th>Transakasi</th>
        <th width="20%">Nama Item</th>
        <th width="15%">Katagori</th>
        <th width="15%">Harga</th>
        
        <th width="15%">Disc</th>
        <th>Qty</th>
        <th width="15%">SubTotal</th>
		</tr>
		</thead>
		<tbody>
			
			@foreach($detil as $k)
			<tr>
			<td>{{$no=$no+1}}</td>
             <td>{{$k->transaksi}}</td>
            <td>{{$k->nama_item}}</td>
            <td>{{$k->katagori_item}}</td>
            <td  align="right">Rp.{{number_format($k->harga_jual,2,',','.')}}</td>
            
            <td  align="right">{{$k->diskon}}</td>
            <td>{{$k->qty}}</td>
            <td align="right">Rp.{{number_format($k->subtotal,2,',','.')}}</td>
			</tr>
			 <?php $total = $total + $k->subtotal ?>;
			@endforeach


		</tbody>
		<tr>
		<td colspan="6" align="right">Total</td>
        <td colspan="2" align="right">{{rupiah($total)}}</td>
        </tr>
	</table>
	<h5>*ini hanya data sementara
	<br>
	<br>
	<br>
	Denpasar , {{tgl_indo(date('Y-m-d'))}}
	<br>
	<br>
	<br>
	<br>
	<br>
	({{ auth()->user()->name}})
 </h5>
</body>
</html>