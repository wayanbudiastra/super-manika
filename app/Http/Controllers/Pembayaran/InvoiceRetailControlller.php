<?php

namespace App\Http\Controllers\Pembayaran;

    use  App\User;
    use App\model\Pembayaran\Kas;
    use App\model\Pembayaran\Pembayaran_retail;
    use App\model\Pembayaran\Pembayaran_retail_detail;
    use \App\model\Registrasi_retail;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Pembayaran\KasRequest;
    use Illuminate\Http\Request;
    use Yajra\DataTables\DataTables;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Facades\Crypt;
    use PDF;
    use Fpdf;

class InvoiceRetailControlller extends Controller
{
    
    public function index()
    {
        //
         $data = Pembayaran_retail::where('aktif','N')->where('closing','N')->get();

         //dd($data);
          return view('pembayaran.invoice_retail.index',['data' => $data,'no' => 0,
            'subtitle'=>'Data Invoice',
            'title'=>'List Invoice Pasien']);
    }

    public function show($id)
    {
        //
           $idx = Crypt::decrypt($id);

         $data = Pembayaran_retail::find($idx);
         $invoice = $data->invoice + 1;
        // dd($data);
         $detil = Pembayaran_retail_detail::where('pembayaran_retail_id',$data->id)->orderby('transaksi','ASC')->get();
         $data->update(['invoice'=> $invoice]);
         //dd($detil);
         $pdf = PDF::loadview('pembayaran.invoice_retail.invoice',
            ['data'=>$data,
             'detil'=>$detil,
             'title' => 'Invoice',
             'no'=> '0',
             'total' => '0'
           ]);
         return $pdf->stream();
    }
    public function edit($id)
    {
          $idx = Crypt::decrypt($id);

         $data = Pembayaran_retail::find($idx);
         $invoice = $data->invoice + 1;
        // dd($data);
         $detil = Pembayaran_retail_detail::where('pembayaran_retail_id',$data->id)->orderby('transaksi','ASC')->get();
         $data->update(['invoice'=> $invoice]);
         //dd($detil);
         $pdf = PDF::loadview('pembayaran.invoice_retail.invoice_copy',
            ['data'=>$data,
             'detil'=>$detil,
             'title' => 'Invoice',
             'no'=> '0',
             'total' => '0'
           ]);
         return $pdf->stream();
    }
   
}
