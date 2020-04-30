<?php

namespace App\Http\Controllers\Pembayaran;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Pembayaran\Pembayaran_retail;
use App\model\Pembayaran\Pembayaran_retail_detail;
use App\model\MasterData\ProdukItem;
use App\model\Inventory\KartuStok;
use App\model\MasterData\Jasa;
use App\model\TindakanItem;
use  App\User;
use App\model\Pembayaran\Kas;
use \App\model\Registrasi\Registrasi_retail;
use App\Http\Requests\Pembayaran\KasRequest;
use App\model\MasterData\Dokter;
use App\model\MasterData\Poli;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use PDF;

class PembayaranRetailDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $data = Pembayaran_retail::where('posting', 'N')->orderby('id','desc')->get();
         //dd($data);

        return view('pembayaran.pembayaran_retail_detil.index', ['data' => $data, 'no' => 0,
           'subtitle' => 'Data Pembayaran',
           'title' => 'List Pembayaran Pasien']);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
        $data = Pembayaran_retail::where('posting','Y')->get();

        dd($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        //
        $idx = Crypt::decrypt($id);
        $data = Pembayaran_retail::find($idx);
        $row = Pembayaran_retail_detail::where('pembayaran_retail_id',$data->id)->get();
        $cekposting = Pembayaran_retail_detail::where('pembayaran_retail_id',$data->id)->where('aktif','N')->count();
        $total = Pembayaran_retail_detail::where('pembayaran_retail_id',$data->id)->sum("subtotal");
        
        if($request->ajax()){
            return view('pembayaran.pembayaran_retail_detil.paginate',
                ['data' => $data,
                    'row' => $row,
                    'total' => $total,
                    'no' => 0,
                    'cekposting' => $cekposting
                ]);
        }

        return view('pembayaran.pembayaran_retail_detil.edit', ['data' => $data,
          
            'row' => $row,
            'no' => 0,
            'total' => $total,
            'title' => 'Add Item Detil Pembayaran',
            'subtitle' => 'List Item Detil Pembayaran',
            'cekposting' => $cekposting
            ]);

    }

    public function showmodalAddTransaksi($id)
    {
        //
        $idx = Crypt::decrypt($id);

        return view('pembayaran.pembayaran_retail_detil.add_transaksi')->with(['idx'=> $idx]);
    }

    public function showmodalAddTransaksiTindakan($id)
    {
        //
        $idx = Crypt::decrypt($id);

        return view('pembayaran.pembayaran_retail_detil.add_tindakan')->with(['idx'=> $idx]);
    }
    
    public function ShowModalItemByAddTransaksi()
    {
        $produk = ProdukItem::where('aktif', '=', 'Y')->get();
        return view('pembayaran.pembayaran_retail_detil.moda_pilih_item')->with([
            'data' => $produk,
            'no' => 0
        ]);
    }
    public function ShowModalItemByAddTransaksiTindakan()
    {
        $produk = Jasa::where('aktif', '=', 'Y')->whereNotIn('harga_jual',['0.00'])->get();
        return view('pembayaran.pembayaran_retail_detil.moda_pilih_tindakan')->with([
            'data' => $produk,
            'no' => 0
        ]);
    }

    public function AddPembayaranDetail(Request $request)
    {
        try {
            $validator = Validator::make(request()->all(), [
                'kode' => 'required',
                'transaksi' => 'required',
                'qty' => 'required|numeric',
            ]);
            $attributeNames = array(
                'kode' => 'Produk Item',
                'transaksi' => 'Transaksi',
                'qty' => 'QTY',

            );
            $validator->setAttributeNames($attributeNames);

            if ($validator->fails()) {
                $message = $validator->errors();
                return   response()->json([
                    'success' => false,
                    'message' => '<p>' . $message->first('kode') . '</p>
                                    <p>' . $message->first('transaksi') . '</p>
                                    <p>' . $message->first('qty') . '</p>',
                ], 433);
            }
            if($request->transaksi == "obat"){

            
            $findData = ProdukItem::find($request->kode);
           
            $kategori =  $findData->produk_katagori->nama_produk_katagori;
            $nama =  $findData->nama_item;
            $jmlstok = $findData->stok - $request->qty;
            //set variable untuk data kartu stok
            $stok_awal = $findData->stok;
            $stok_masuk = 0;
            $stok_keluar = $request->qty;
            $stok_akhir = $jmlstok;
            if($jmlstok < 0){
                return   response()->json([
                    'success' => false,
                    'message' => '<p> Sisa Stok Kurang Dari 0</p>'

                ],433);
            }
            else{
                ProdukItem::where('id',$request->kode)->update([
                    'stok' =>$jmlstok
                ]);
            
                // input kartu stok
                $kartustok = new KartuStok;
                $kartustok->periode = GetPeriode();
                $kartustok->produk_item_id = $findData->id;
                $kartustok->stok_awal = $stok_awal;
                $kartustok->stok_masuk = $stok_masuk;
                $kartustok->stok_keluar = $stok_keluar;
                $kartustok->stok_akhir = $stok_akhir;
                $kartustok->transaksi = "PENJUALAN";
                $kartustok->keterangan = "Penjualan Item dengan transaksi retail ".$request->pembayaran_id;
                $kartustok->users_id = auth()->user()->id;
                $kartustok->save();
            }

        }
        else{
            $findData = Jasa::find($request->kode);
            $kategori =  $findData->jasakatagori->nama_jasakatagori;
            $nama =  $findData->nama_jasa;

        }
        
        if($request->diskon == NULL){
            $diskon = 0;
        }
        else{
                $diskon = str_replace(".","",str_replace("Rp. ","",$request->diskon));
        }
        $cekdiskon = $findData->harga_jual - $diskon;
            $total = $request->qty * $cekdiskon;
                Pembayaran_retail_detail::create([
                'pembayaran_retail_id'=> $request->pembayaran_id,
                'transaksi'=> $request->transaksi,
                'kode_item'=> $findData->kode,
                'nama_item'=> $nama,
                'katagori_item'=> $kategori,
                'qty'=> $request->qty,
                'harga_jual'=> $findData->harga_jual,
                'payer_net'=> 0,
                'pasien_net'=> 0,
                'subtotal'=> $total,
                'diskon' => $diskon,
                'remember_token' => str_random(20),
                'fee_staff'=> $findData->fee_staff,
                'fee_dokter'=> $findData->fee_dokter,
                'fee_asisten'=> $findData->fee_asisten,
                'users_id'=> auth()->user()->id,
            ]);

            return response()->json([
                'success' => true,

                'message' => "Data Berhasil di input"
            ], 200);
        } catch (\Exception $e) {
            // store errors to log
            \Log::error('class : ' . PembayaranDetilController::class . ' method : create | ' . $e);

            return response()->json([
                'success' => false,

                'message' => "Data Gagal di Input ".$e 
            ], 500);
        }

    }
    
    public function DeletePembayaranDetail($id)
    {
        try {
            $findPembayaranDetail = Pembayaran_retail_detail::find($id);
            if($findPembayaranDetail->transaksi == "obat"){
            $findData = ProdukItem::where('kode',$findPembayaranDetail->kode_item)->first();
            $jmlstok = $findPembayaranDetail->qty + $findData->stok;
            ProdukItem::where('id',$findData->id)->update([
                'stok' =>$jmlstok
            ]);
            //input kartu stok 
            $stok_awal = $findData->stok;
            $stok_masuk = $findPembayaranDetail->qty;
            $stok_keluar = 0;
            $stok_akhir = $jmlstok;

             $kartustok = new KartuStok;
             $kartustok->periode = GetPeriode();
             $kartustok->produk_item_id = $findData->id;
             $kartustok->stok_awal = $stok_awal;
             $kartustok->stok_masuk = $stok_masuk;
             $kartustok->stok_keluar = $stok_keluar;
             $kartustok->stok_akhir = $stok_akhir;
             $kartustok->transaksi = "HAPUS PENJUALAN";
             $kartustok->keterangan = "Hapus Penjualan Item dengan transaksi retail".$findPembayaranDetail->pembayaran_id;
             $kartustok->users_id = auth()->user()->id;
             $kartustok->save();
            }
            Pembayaran_retail_detail::where('id',$id)->delete();

            return response()->json([
                'success' => true,

                'message' => "Data Berhasil di Hapus"
            ], 200);
        } catch (\Exception $e) {
            // store errors to log
            \Log::error('class : ' . PembayaranDetilController::class . ' method : edit | ' . $e);

            return response()->json([
                'success' => false,

                'message' => "Data Gagal di Hapus"
            ], 500);
        }

    }

    public function Posting($id,Request $request)
    {
        try {
        
            $idx = Crypt::decrypt($id);
            $data = Pembayaran_retail::find($idx);
            Pembayaran_retail_detail::where('pembayaran_retail_id',$data->id)->update([
                'aktif' =>$request->value
            ]);

            if($request->value=='Y'){
                $posting = 'N';
            }else{
                $posting = 'Y';
            }
            Pembayaran_retail::where('id',$data->id)->update([
                'posting' => $posting
            ]);
        

            return response()->json([
                'success' => true,

                'message' => "Data Berhasil di Posting"
            ], 200);
        } catch (\Exception $e) {
            // store errors to log
            \Log::error('class : ' . PembayaranDetilController::class . ' method : posting | ' . $e);

            return response()->json([
                'success' => false,

                'message' => "Data Gagal di Posting"
            ], 500);
        }

    }
   
    public function printprev($id){
         $idx = Crypt::decrypt($id);

         $data = Pembayaran_retail::find($idx);
        // dd($data);
         $detil = Pembayaran_retail_detail::where('pembayaran_retail_id',$data->id)->orderby('transaksi','ASC')->get();

         //dd($detil);
         $pdf = PDF::loadview('pembayaran.pembayaran_retail_detil.printprev',
            ['data'=>$data,
             'detil'=>$detil,
             'title' => 'Bill Sementara',
             'no'=> '0',
             'total' => '0'
           ]);
         return $pdf->stream();
    }
  
}
