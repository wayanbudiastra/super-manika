<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Pembayaran\Pembayaran;
use App\model\Pembayaran\PembayaranDetil;
use App\model\Pembayaran\Pembayaran_retail;
use App\model\Pembayaran\Pembayaran_retail_detail;
use App\model\MasterData\Asdok;
use DB;
use FPDF;
use App\Exports\FeeAsistenExport;
use Maatwebsite\Excel\Facades\Excel;


class FeeAsistenController extends Controller
{
    //
    public function index(){

        $data = DB::table('pembayaran_detil')
        ->select(
            'pembayaran.no_invoice',
            'registrasi1.no_registrasi',
            'asdok.nama_asdok',
            'pembayaran_detil.transaksi',
            'pembayaran.tgl_pembayaran',   
            'pembayaran_detil.nama_item',
            'pembayaran_detil.harga_jual',
            'pembayaran_detil.qty',
            'pembayaran_detil.fee_asisten')
        ->join('pembayaran','pembayaran_detil.pembayaran_id','pembayaran.id')
        ->join('registrasi1','pembayaran.registrasi1_id','registrasi1.id')
        ->join('asdok','registrasi1.asdok_id','asdok.id')
        ->where('pembayaran.tgl_pembayaran',date('Y-m-d'))
        ->where('pembayaran_detil.aktif','N')
        ->get();
        //dd($data);

        return view('report.pendapatan.feeasdok.index',[
            'title' => 'Fee Transaksi Asisten Dokter',
            'subtitle' => 'Registrasi Reguler',
            'data' => $data,
            'asdok_id' => 0,
            'tgl_mulai' => date('Y-m-d'),
            'tgl_selesai' => date('Y-m-d'),
            'asdok' => Asdok::where('aktif','Y')->get(),
        ]);
    }

    public function get_data(Request $request){
        $data = DB::table('pembayaran_detil')
        ->select(
            'pembayaran.no_invoice',
            'registrasi1.no_registrasi',
            'asdok.nama_asdok',
            'pembayaran_detil.transaksi',
            'pembayaran.tgl_pembayaran',   
            'pembayaran_detil.nama_item',
            'pembayaran_detil.harga_jual',
            'pembayaran_detil.qty',
            'pembayaran_detil.fee_asisten')
        ->join('pembayaran','pembayaran_detil.pembayaran_id','pembayaran.id')
        ->join('registrasi1','pembayaran.registrasi1_id','registrasi1.id')
        ->join('asdok','registrasi1.asdok_id','asdok.id')
        ->whereBetween('pembayaran.tgl_pembayaran',[$request->tgl_mulai, $request->tgl_selesai])
        ->where('registrasi1.asdok_id',$request->asdok_id)
        ->where('pembayaran_detil.aktif','N')
        ->get();

        //dd($data);
        return view('report.pendapatan.feeasdok.index',[
            'title' => 'Fee Transaksi Asisten Dokter',
            'subtitle' => 'Registrasi Reguler',
            'data' => $data,
            'asdok' => Asdok::where('aktif','Y')->get(),
            'asdok_id' => $request->asdok_id,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,

        ]);
    }

    public function cetak_pdf(Request $request){
        $data = DB::table('pembayaran_detil')
        ->select(
            'pembayaran.no_invoice',
            'registrasi1.no_registrasi',
            'asdok.nama_asdok',
            'pembayaran_detil.transaksi',
            'pembayaran.tgl_pembayaran',   
            'pembayaran_detil.nama_item',
            'pembayaran_detil.harga_jual',
            'pembayaran_detil.qty',
            'pembayaran_detil.fee_asisten')
        ->join('pembayaran','pembayaran_detil.pembayaran_id','pembayaran.id')
        ->join('registrasi1','pembayaran.registrasi1_id','registrasi1.id')
        ->join('asdok','registrasi1.asdok_id','asdok.id')
        ->whereBetween('pembayaran.tgl_pembayaran',[$request->tgl_mulai, $request->tgl_selesai])
        ->where('registrasi1.asdok_id',$request->asdok_id)
        ->where('pembayaran_detil.aktif','N')
        ->get();

        //dd($data);
        $pdf = new FPDF();
        $pdf::AddPage("L","A4");
        $pdf::SetFont('Arial','B',18);
        $pdf::Cell(0,10,"Laporan Pendapatan Fee Asisten Dokter",0,"","C");
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
        $pdf::cell(35,6,"Asisten Dokter",1,"","L");
        $pdf::cell(35,6,"Fee Asisten Dokter",1,"","L");
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
            $pdf::Cell(35,6,$x->nama_asdok,1,"","L");
            $pdf::Cell(35,6,rupiah($x->fee_asisten),1,"","R");
            $pdf::Cell(15,6,$x->qty,1,"","C");
            $pdf::Cell(35,6,rupiah($x->qty * $x->fee_asisten),1,"","R");
            $pdf::Ln();
            $total = $total + ($x->qty * $x->fee_asisten);
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
         return Excel::download(new FeeAsistenExport
         ($request->tgl_mulai, 
         $request->tgl_selesai, 
         $request->asdok_id), 'Asisten_Fee_'.date('Y-m-d').'.xlsx');
     }

}
