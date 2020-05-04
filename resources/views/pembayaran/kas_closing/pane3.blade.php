<div class="table-responsive">
    <br>
    <div class="text-center"><h2>Data Kas Manual </h2> </div>
    <table id="basic-datatables2" class="display table table-striped table-hover">
        <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Transaksi</th>
                                            <th>Keterangan</th>
                                            <th>Kas Masuk</th>
                                            <th>Kas Keluar</th>
                                            
                                           
                                        </tr>
                                        </thead>
                                        @php
                                            $total_kasManual = 0;
                                        @endphp
                                        <tbody>
                                        @foreach($kas_manual as $k)
                                            <tr>
                                                <td>{{$no=$no+1}}</td>
                                                <td>{{$k->transaksi}}</td>
                                                <td>{{$k->keterangan}}</td>
                                                <td>{{rupiah($k->kas_masuk)}}</td>
                                                <td>{{rupiah($k->kas_keluar)}}</td>
                                            
                                            </tr>
                                        @endforeach
                                        </tbody>
    </table>


</div>