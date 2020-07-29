<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\MasterData\Dokter;
use App\model\MasterData\Spesialis;
use App\model\MasterData\SubSpesialis;
use FPDF;
use App\Exports\DokterExport;
use Maatwebsite\Excel\Facades\Excel;

class DokterController extends Controller
{
    //
    public function index(){
            $row              = Dokter::orderBy('id', 'desc')->get();
            $dataspesialis    = Spesialis::get()->toArray();
            $datasubspesialis = SubSpesialis::get()->toArray();

            return view('report.masterdata.dokter.index')->with([
                'data'             => $row,
                'dataSpesialis'    => $dataspesialis,
                'dataSubSpesialis' => $datasubspesialis,
                'title'            => 'Data Dokter',
                'subtitle'         => 'List Dokter',
                'no'               => '0',
            ]);
    }

    public function cetak_pdf(){
        $data = Dokter::all();

        $pdf = new FPDF();
        $pdf::AddPage("L","A4");
        $pdf::SetFont('Arial','B',18);
        $pdf::Cell(0,10,"Data Dokter",0,"","C");
        $pdf::Ln();
        $pdf::Ln();
        $pdf::SetFont('Arial','B',10);
        $pdf::Cell(0,6,"Tgl Cetak : ".
        tgl_indo(date('Y-m-d')),0,"","L");
        $pdf::Ln();
        $pdf::SetFont('Arial','B',10);
        $pdf::cell(10,6,"No",1,"","C");
        $pdf::cell(35,6,"Nik",1,"","L");
        $pdf::cell(45,6,"Nama Dokter",1,"","L");
        
        $pdf::cell(25,6,"Tanggal Lahir",1,"","L");
        $pdf::cell(65,6,"Alamat",1,"","L");
        $pdf::cell(55,6,"Email",1,"","L");
        $pdf::cell(35,6,"No HP",1,"","L");
        
        $pdf::Ln();
        $pdf::SetFont("Arial","",10);
        // $datasiswa=siswa::all();
        $no = 1;
        
        foreach($data as $x){
            $pdf::Cell(10,6,$no, 1,"","L");
            $pdf::cell(35,6,$x->nik,1,"","L");
            $pdf::cell(45,6,$x->nama_dokter,1,"","L");
           
            $pdf::cell(25,6,$x->tgl_lahir,1,"","L");
            $pdf::Cell(65,6,$x->alamat,1,"","L");
            $pdf::Cell(55,6,$x->email,1,"","L");
            $pdf::Cell(35,6,$x->no_telp,1,"","R");
            
            // $pdf::Cell(35,6,rupiah($x->qty * $x->fee_asisten),1,"","R");
            $pdf::Ln();
            
            $no++;
        }
                    
        $pdf::Output();
        exit;

    }

    public function cetak_excel(){
        // dd($request->all());
         return Excel::download(new DokterExport, 'dokter_list_'.date('Y-m-d').'.xlsx');
     }
}
