<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\MasterData\Pasien;
use DB;
use FPDF;
use App\Exports\PasienExport;
use Maatwebsite\Excel\Facades\Excel;


class PasienController extends Controller
{
    //
    public function index(){
        $data = DB::table('pasien')->select(
            'nama',
            'alamat',
            'no_telp',
            'aktif'
        )->get();

        return view('report.masterdata.pasien.index')->with([
            'data'             => $data,
            'title'            => 'Data Pasien',
            'subtitle'         => 'List Pasien',
            'no'               => '0',
        ]);
    }

    public function cetak_pdf(){
        $data = DB::table('pasien')->select(
            'nama',
            'alamat',
            'no_telp',
            'aktif',
            'nocm'
        )->get();

        $pdf = new FPDF();
        $pdf::AddPage("L","A4");
        $pdf::SetFont('Arial','B',18);
        $pdf::Cell(0,10,"Data Pasien",0,"","C");
        $pdf::Ln();
        $pdf::Ln();
        $pdf::SetFont('Arial','B',10);
        $pdf::Cell(0,6,"Tgl Cetak : ".
        tgl_indo(date('Y-m-d')),0,"","L");
        $pdf::Ln();
        $pdf::SetFont('Arial','B',10);
        $pdf::cell(10,6,"No",1,"","C");
        $pdf::cell(15,6,"NO MR",1,"","L");
        $pdf::cell(70,6,"Nama Pasien",1,"","L");
        
        $pdf::cell(120,6,"Alamat",1,"","L");
        $pdf::cell(55,6,"No Telp",1,"","L");
        
        $pdf::Ln();
        $pdf::SetFont("Arial","",10);
        // $datasiswa=siswa::all();
        $no = 1;
        
        foreach($data as $x){
            $pdf::Cell(10,6,$no, 1,"","L");
            $pdf::cell(15,6,$x->nocm,1,"","L");
            $pdf::cell(70,6,$x->nama,1,"","L");
            $pdf::cell(120,6,$x->alamat,1,"","L");
            $pdf::Cell(55,6,$x->no_telp,1,"","L");
            
            // $pdf::Cell(35,6,rupiah($x->qty * $x->fee_asisten),1,"","R");
            $pdf::Ln();
            
            $no++;
        }
                    
        $pdf::Output();
        exit;
        
    }


    public function cetak_excel(){
        // dd($request->all());
         return Excel::download(new PasienExport, 'pasien_list_'.date('Y-m-d').'.xlsx');
     }

}
