<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Pembayaran\Pembayaran;
use App\model\Pembayaran\PembayaranDetil;
use App\model\Pembayaran\Pembayaran_retail;
use App\model\Pembayaran\Pembayaran_retail_detail;
use DB;
use FPDF;
use App\Exports\PendapatanExport;
use Maatwebsite\Excel\Facades\Excel;

class PendapatanController extends Controller
{
    //
    public function index(){
        $data = DB::table('pembayaran_detil')
        ->join('pembayaran','pembayaran_detil.pembayaran_id','pembayaran.id')
        ->where('pembayaran.tgl_pembayaran',date('Y-m-d'))
        ->where('pembayaran_detil.aktif','N')
        ->get();
        //dd($data);

        return view('report.pendapatan.index',[
            'title' => 'Pendapatan Transaksi',
            'subtitle' => 'Registrasi RM & Retail',
            'data' => $data
        ]);
    }

    public function cetak_pdf(Request $request){
        // dd($request->all());
        $data = DB::table('pembayaran_detil')
        ->join('pembayaran','pembayaran_detil.pembayaran_id','pembayaran.id')
        ->whereBetween('pembayaran.tgl_pembayaran',[$request->tgl_mulai, $request->tgl_selesai])
        ->where('pembayaran_detil.aktif','N')
        ->get();
        //dd($data);

        // return response()->json([

        // ],200);

        $pdf = new FPDF();
        $pdf::AddPage("L","A4");
        $pdf::SetFont('Arial','B',18);
        $pdf::Cell(0,10,"Laporan Pendapatan",0,"","C");
        $pdf::Ln();
        $pdf::Ln();
        $pdf::SetFont('Arial','B',10);
        $pdf::Cell(0,6,"Periode : ".
        tgl_indo($request->tgl_mulai)." s/d ".
        tgl_indo($request->tgl_selesai),0,"","L");
        $pdf::Ln();
        $pdf::SetFont('Arial','B',10);
        $pdf::cell(10,6,"No",1,"","C");
        $pdf::cell(35,6,"No Invoice",1,"","L");
        $pdf::cell(35,6,"Transaksi",1,"","L");
        $pdf::cell(25,6,"Tanggal",1,"","L");
        $pdf::cell(65,6,"Item",1,"","L");
        $pdf::cell(35,6,"Harga",1,"","L");
        $pdf::cell(35,6,"Qty",1,"","L");
        $pdf::cell(35,6,"Sub Total",1,"","L");
        $pdf::Ln();
        $pdf::SetFont("Arial","",10);
        // $datasiswa=siswa::all();
        $no = 0;
        $total=0;
        foreach($data as $x){
            $pdf::Cell(10,6,$no+1, 1,"","L");
            $pdf::cell(35,6,$x->no_invoice,1,"","L");
            $pdf::cell(35,6,$x->transaksi,1,"","L");
            $pdf::cell(25,6,$x->tgl_pembayaran,1,"","L");
            $pdf::Cell(65,6,$x->nama_item,1,"","L");
            $pdf::Cell(35,6,rupiah($x->harga_jual),1,"","R");
            $pdf::Cell(35,6,$x->qty,1,"","L");
            $pdf::Cell(35,6,rupiah($x->subtotal),1,"","R");
            $pdf::Ln();
            $total = $total + $x->subtotal;
        }

        $pdf::Output();
        exit;

    }

    public function cetak_excel(Request $request){

       // dd($request->all());
        return Excel::download(new PendapatanExport($request->tgl_mulai, $request->tgl_selesai), 'Pendapatan.xlsx');
    }
}
