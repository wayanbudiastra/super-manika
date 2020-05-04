<div class="table-responsive">
    <br>
    <div class="text-center"><h2>Data pembayaran Retail </h2> </div>
    <table id="basic-datatables2" class="display table table-striped table-hover">
         <thead>
                       <tr>
                        <th>No</th>
                        <th>No Registrasi</th>
                        <th>Type Pasien</th>
                        <th>Nama Pasien</th>
                        <th width="18%">Tgl Lahir</th>
                        <!-- <th>Usia</th> -->
                        <th>Keterangan</th>
                        <th>Total_transaksi</th>
                        </tr>
                      </thead>
                     
                      <tbody>
                          @foreach($pembayaran_retail as $k)
                            @php
                                $type_pasien ="";
                                $nama_pasien ="";
                                $tgl_lahir = "";
                            @endphp

                            <?php $id = Crypt::encrypt($k->id); ?>
                            @php
                                if($k->registrasi_retail->jenis_registrasi_retail_id=='umum'){
                                    $type_pasien = 'umum';
                                    $nama_pasien = 'umum';
                                    $tgl_lahir = "-";
                                }else{
                                    $type_pasien = 'pasien';
                                     $nama_pasien = info_pasien_nama($k->registrasi_retail->pasien_id);
                                    $tgl_lahir = tgl_indo(info_pasien_tgl_lahir($k->registrasi_retail->pasien_id));
                                }
                            @endphp
                            <tr>
                            <td>{{$no=$no+1}}</td>
                            <td>{{$k->registrasi_retail->no_registrasi}}</a></td>
                            <td>{{$type_pasien}}</a></td>
                            <td>{{$nama_pasien}}</td>
                            <td>{{$tgl_lahir}}</td>
                            <!-- <td>{{hitung_usia($k->tgl_lahir)}}</td> -->
                            <td>{{$k->registrasi_retail->keterangan}}</td>
                            <td>{{rupiah($k->total_transaksi)}}
                            </td>
                            </tr>
                            
                            @endforeach


                      </tbody>
    </table>
</div>