<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Pembayaran\Pembayaran;
use App\model\Pembayaran\PembayaranDetil;
use App\model\Pembayaran\Pembayaran_retail;
use App\model\Pembayaran\Pembayaran_retail_detail;
use App\model\MasterData\Dokter;
use DB;
use FPDF;
use App\Exports\FeeDokterExport;
use Maatwebsite\Excel\Facades\Excel;


class FeeController extends Controller
{
    //
    public function index(){

        $data = DB::table('pembayaran_detil')
        ->select(
            'pembayaran.no_invoice',
            'registrasi1.no_registrasi',
            'dokter.nama_dokter',
            'pembayaran_detil.transaksi',
            'pembayaran.tgl_pembayaran',   
            'pembayaran_detil.nama_item',
            'pembayaran_detil.harga_jual',
            'pembayaran_detil.qty',
            'pembayaran_detil.fee_dokter')
        ->join('pembayaran','pembayaran_detil.pembayaran_id','pembayaran.id')
        ->join('registrasi1','pembayaran.registrasi1_id','registrasi1.id')
        ->join('dokter','registrasi1.dokter_id','dokter.id')
        ->where('pembayaran.tgl_pembayaran',date('Y-m-d'))
        ->where('pembayaran_detil.aktif','N')
        ->get();
        //dd($data);

        return view('report.pendapatan.fee.index',[
            'title' => 'Fee Transaksi',
            'subtitle' => 'Registrasi RM & Retail',
            'data' => $data,
            'dokter_id' => 0,
            'tgl_mulai' => date('Y-m-d'),
            'tgl_selesai' => date('Y-m-d'),
            'dokter' => Dokter::where('aktif','Y')->get(),
        ]);
    }

    public function get_dokter(Request $request){
        $data = DB::table('pembayaran_detil')
        ->select(
            'pembayaran.no_invoice',
            'registrasi1.no_registrasi',
            'dokter.nama_dokter',
            'pembayaran_detil.transaksi',
            'pembayaran.tgl_pembayaran',   
            'pembayaran_detil.nama_item',
            'pembayaran_detil.harga_jual',
            'pembayaran_detil.qty',
            'pembayaran_detil.fee_dokter')
        ->join('pembayaran','pembayaran_detil.pembayaran_id','pembayaran.id')
        ->join('registrasi1','pembayaran.registrasi1_id','registrasi1.id')
        ->join('dokter','registrasi1.dokter_id','dokter.id')
        ->whereBetween('pembayaran.tgl_pembayaran',[$request->tgl_mulai, $request->tgl_selesai])
        ->where('registrasi1.dokter_id',$request->dokter_id)
        ->where('pembayaran_detil.aktif','N')
        ->get();

        //dd($data);
        return view('report.pendapatan.fee.index',[
            'title' => 'Fee Dokter Transaksi',
            'subtitle' => 'Registrasi RM & Retail',
            'data' => $data,
            'dokter' => Dokter::where('aktif','Y')->get(),
            'dokter_id' => $request->dokter_id,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,

        ]);
    }

    public function cetak_pdf(Request $request){
        $data = DB::table('pembayaran_detil')
        ->select(
            'pembayaran.no_invoice',
            'registrasi1.no_registrasi',
            'dokter.nama_dokter',
            'pembayaran_detil.transaksi',
            'pembayaran.tgl_pembayaran',   
            'pembayaran_detil.nama_item',
            'pembayaran_detil.harga_jual',
            'pembayaran_detil.qty',
            'pembayaran_detil.fee_dokter')
        ->join('pembayaran','pembayaran_detil.pembayaran_id','pembayaran.id')
        ->join('registrasi1','pembayaran.registrasi1_id','registrasi1.id')
        ->join('dokter','registrasi1.dokter_id','dokter.id')
        ->whereBetween('pembayaran.tgl_pembayaran',[$request->tgl_mulai, $request->tgl_selesai])
        ->where('registrasi1.dokter_id',$request->dokter_id)
        ->where('pembayaran_detil.aktif','N')
        ->get();

        //dd($data);
        $pdf = new FPDF();
        $pdf::AddPage("L","A4");
        $pdf::SetFont('Arial','B',18);
        $pdf::Cell(0,10,"Laporan Pendapatan Fee Dokter",0,"","C");
        $pdf::Ln();
        $pdf::Ln();
        $pdf::SetFont('Arial','B',10);
        $pdf::Cell(0,6,"Periode : ".
        tgl_indo($request->tgl_mulai)." s/d ".
        tgl_indo($request->tgl_selesai),0,"","L");
        $pdf::Ln();
        $pdf::SetFont('Arial','B',10);
        $pdf::cell(10,6,"No",1,"","C");
        $pdf::cell(25,6,"No Invoice",1,"","L");
        $pdf::cell(25,6,"Transaksi",1,"","L");
        $pdf::cell(25,6,"Tanggal",1,"","L");
        $pdf::cell(65,6,"Item",1,"","L");
        $pdf::cell(35,6,"Dokter",1,"","L");
        $pdf::cell(35,6,"Fee Dokter",1,"","L");
        $pdf::cell(15,6,"Qty",1,"","L");
        $pdf::cell(35,6,"Sub Total",1,"","L");
        $pdf::Ln();
        $pdf::SetFont("Arial","",10);
        // $datasiswa=siswa::all();
        $no = 1;
        $total=0;
        foreach($data as $x){
            $pdf::Cell(10,6,$no, 1,"","L");
            $pdf::cell(25,6,$x->no_invoice,1,"","L");
            $pdf::cell(25,6,$x->transaksi,1,"","L");
            $pdf::cell(25,6,tgl_indo($x->tgl_pembayaran),1,"","L");
            $pdf::Cell(65,6,$x->nama_item,1,"","L");
            $pdf::Cell(35,6,$x->nama_dokter,1,"","L");
            $pdf::Cell(35,6,rupiah($x->fee_dokter),1,"","R");
            $pdf::Cell(15,6,$x->qty,1,"","C");
            $pdf::Cell(35,6,rupiah($x->qty * $x->fee_dokter),1,"","R");
            $pdf::Ln();
            $total = $total + ($x->qty * $x->fee_dokter);
            $no++;
        }
           $pdf::Cell(10,6,"-", 1,"","L");
            $pdf::Cell(225,6,"Total",1,"","R");
            $pdf::Cell(35,6,rupiah($total),1,"","R");
            $pdf::Ln();

        $pdf::Output();
        exit;


    }

    public function cetak_excel(Request $request){
        // dd($request->all());
         return Excel::download(new FeeDokterExport
         ($request->tgl_mulai, 
         $request->tgl_selesai, 
         $request->dokter_id), 'Dokter_Fee_'.date('Y-m-d').'.xlsx');
     }
}
