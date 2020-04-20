<div class="table-responsive">
    <br>
    <div class="text-center"><h2>Data pembayaran Rawat Jalan </h2> </div>
    <table id="basic-datatables1" class="display table table-striped table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>No Reg</th>
            <th>Nama Pasien</th>
            <th>Dokter</th>
            <th>Poli</th>
            <th>Tgl Reg</th>
            <th>Total Transaksi</th>
        </tr>
        </thead>

        <tbody>
             @foreach($pembayaran as $k)
                                            <tr>
                                                <td>{{$no=$no+1}}</td>
                            <td>{{$k->registrasi1->no_registrasi}}</td>
                            <td>{{$k->registrasi1->pasien->nama}}</td>
                            <td>{{$k->registrasi1->dokter->nama_dokter}}</td>
                            <td>{{$k->registrasi1->poli->nama_poli}}</td>
                            <!-- <td>{{hitung_usia($k->tgl_lahir)}}</td> -->
                            <td>{{tgl_indo($k->registrasi1->tgl_reg)}}</td>
                            <td align="right">{{rupiah($k->total_transaksi)}}</td>
                           
                </tr>
            @endforeach
            <tr>
                <td colspan="6" align="right"> <h4>Total Transaksi</h4></td>
                <td align="right"> {{rupiah($total_pembayaran)}}</td>
            </tr>
        </tbody>
    </table>


    
</div>