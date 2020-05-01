<?php

namespace App\Http\Controllers\Pembayaran;

use  App\User;
use App\model\Pembayaran\Kas;
use App\model\Pembayaran\Pembayaran_retail;
use App\model\Pembayaran\Pembayaran_retail_detail;
use \App\model\Registrasi_retail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PembayaranRetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Registrasi_retail::where([['aktif','=','Y'],['iscencel','=','N']])->get();
        //dd($data);
       
        return view('pembayaran.pembayaran_retil.index',['data' => $data,'no' => 0,
            'subtitle'=>'Data Registrasi',
            'title'=>'List Registrasi Pasien']);
       
    }

   

   
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }

    public function lanjut_ajax($id){
        

      //  $data = Registrasi1::find($id);
       // dd($data);

         // return response()->json([
         //        'success' => true,
         //        'data' => $data,
         //        'message' => "Data Berhasil di input"
         //    ], 200);
        $user = auth()->user()->id;
        $tgl_open =  date("Y-m-d");
        $cek = Kas::where([
            ['users_id','=',$user],
            ['tgl_open','=',date("Y-m-d")],
        ])->get();

//dd($cek1);
       //cek apakah sudah melakukan open kas di hari tersebut
       if($cek->first()){
          try{
            $pembayaran_retail = new Pembayaran_retail;
            $pembayaran_retail->tgl_pembayaran = date("Y-m-d");
            $pembayaran_retail->kas_id = $cek->first()->id;
            $pembayaran_retail->registrasi_retail_id = $id;
            $pembayaran_retail->total_transaksi = 0;
            $pembayaran_retail->total_diskon = 0;
            $pembayaran_retail->total_kembali = 0;
            $pembayaran_retail->total_pembayaran = 0;
            $pembayaran_retail->kurang_bayar = 0;
            $pembayaran_retail->invoice = 0;
            $pembayaran_retail->posting = 'N';
            $pembayaran_retail->aktif = 'Y';
            $pembayaran_retail->cencel = 'N';
            $pembayaran_retail->closing = 'N';
            $pembayaran_retail->users_id = $user;
            $pembayaran_retail->remember_token = str_random(20);
            $pembayaran_retail->save();

            $data = Registrasi_retail::find($id);
            //$request->request->add(['aktif'=>'N']);
            $data->update(['aktif'=>'N']);
          
            return response()->json([
                'success' => true,
                'message' => "Data Berhasil di input"
            ], 200);
            } catch (\Exception $e) {
            // store errors to log
             \Log::error('class : '. PembayaranController::class . ' method : create | '. $e);
              return response()->json([
                'success' => false,
                'message' => $e
            ], 500);
           }       
       }
       else{
          // return redirect('/pembayaran')->with('gagal', 'Silahkan melakukan open kas terlebih dahulu..!');
            return response()->json([
                'success' => false,
                'cek' => $cek->toArray(),
                'message' => "Silahkan melakukan open kas...!!"
            ], 500);
       }    
    }

    public function show(){
        $data = Pembayaran_retail::where('posting', 'Y')->where('aktif','Y')->orderby('id','desc')->get();
       // dd($data);

       return view('pembayaran.pembayaran_retil.show', ['data' => $data, 'no' => 0,
           'subtitle' => 'Data Pembayaran',
           'title' => 'List Pembayaran Pasien']);
   }

    public function showmodalAddpembayaran($id){

        $data = Pembayaran_retail::where('id', '=', $id)->get()->first();
        $total = Pembayaran_retail_detail::where('pembayaran_retail_id', $id)->sum("subtotal");

        // dd($data);
       
        if($data->registrasi_retail->jenis_registrasi_retail_id=='umum'){
            $type_pasien = 'umum';
            $nama_pasien = 'umum';
            $tgl_lahir = "-";
        }else{
            $type_pasien = 'pasien';
            $nama_pasien = info_pasien_nama($data->registrasi_retail->pasien_id);
            $tgl_lahir = tgl_indo(info_pasien_tgl_lahir($data->registrasi_retail->pasien_id));
        }
                            

        return  response()->json([
                     'data' => $data,
                     'no_registrasi'=>$data->registrasi_retail->no_registrasi,
                     'pasien'=> $nama_pasien,
                     'dokter'=> $type_pasien,
                     'poli'=> $tgl_lahir,
                     'total'=> $total,
                     'terbilang' => terbilang($total),
                     'id'=> $id
                 ]);
       
    }

    public function SimpanInvoice(Request $request){

        
         try {
        $kode = Pembayaran_retail::max('no_invoice');
        $no_invoice = nomor_invoice_retail($kode);

        $id = $request->id;
        $data = Pembayaran_retail::where('id',$id)->update([
            'no_invoice'=>$no_invoice,
            'total_transaksi'=> $request->total,
            'total_pembayaran'=> $request->pembayaran,
            'aktif'=> 'N',
            'invoice'=> '1',
            'total_kembali'=> $request->kembali]);

        //

        return response()->json([
            'data' => $data,
            'no_invoice'=> $no_invoice,
            'request' => $request->all()
        ]);

        } catch (\Exception $e) {
            // store errors to log
            \Log::error('class : ' . PembayaranRetailController::class . ' method : create | ' . $e);

            return response()->json([
                'success' => false,
               // 'cek' => $cek,
                'message' => "Data Gagal di Input"
            ], 500);
        }


    }

}
