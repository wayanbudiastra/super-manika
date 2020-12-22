<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\Pembayaran\Kas;
use App\model\Pembayaran\Pembayaran;
use App\model\Pembayaran\Pembayaran_retail;
use App\model\Pembayaran\Kas_manual;
use FPDF;

    

class ClosingController extends Controller
{
    //
    public function index(){
        $data = Kas::where('aktif','N')->get();
       // dd($data);
       return view('report.closing.index',[
           'title'=> 'Closing Report',
           'subtitle'=> 'Kas Closing',
           'data'=>$data,
           'no'=>0
       ]);
    }

    public function edit($id){
        $kas = Kas::find($id);
        $pembayaran = Pembayaran::where('kas_id','=',$id)->get();
        $kas_manual = Kas_manual::where('kas_id','=',$id)->get();
        $pembayaran_retail = Pembayaran_retail::where('kas_id','=',$id)->get();
        //dd($data);

        return view('report.closing.kas_closing')->with([
            'pembayaran'             => $pembayaran,
            'total_pembayaran'       => total_pembayaran($pembayaran),//ambil dari helper global
            'kas_manual'             => $kas_manual,
            'total_kasManual'        => total_kasManual($kas_manual),
            'kas'                    => $kas,
            'pembayaran_retail'      => $pembayaran_retail,
            'total_pembayaran_retail'=> total_pembayaran_retail($pembayaran_retail),
            'title'                  => 'Data Kas',
            'subtitle'               => 'Proses Closing',
            'no'                     => '0',
        ]);
    }


    public function cetak_pdf($id){

        $kas = Kas::find($id);
        $pembayaran = Pembayaran::where('kas_id','=',$id)->get();
        $kas_manual = Kas_manual::where('kas_id','=',$id)->get();
        $pembayaran_retail = Pembayaran_retail::where('kas_id','=',$id)->get();

        $pdf = new FPDF();
        $pdf::AddPage("L","A4");
        $pdf::SetFont('Arial','B',18);
        $pdf::Cell(0,10,"Data Closing Kas",0,"","C");
        $pdf::Ln();
        $pdf::Ln();
        $pdf::SetFont('Arial','B',10);
        $pdf::Cell(0,6,"Tgl Cetak : ".
        tgl_indo(date('Y-m-d')),0,"","L");
        $pdf::Ln();
        if($pembayaran){        
        $pdf::Cell(0,6,"Rawat Jalan : ",0,"","L");
        $pdf::Ln();
        

        $pdf::SetFont('Arial','B',10);
        $pdf::cell(10,6,"No",1,"","C");
        $pdf::cell(35,6,"No Reg",1,"","L");
        $pdf::cell(65,6,"Nama Pasien",1,"","L");
        $pdf::cell(65,6,"Dokter",1,"","L");
        $pdf::cell(25,6,"Poli",1,"","L");
        $pdf::cell(35,6,"Tgl Reg",1,"","L");
        $pdf::cell(35,6,"Total Transaksi",1,"","L");
        
        $pdf::Ln();
        $pdf::SetFont("Arial","",10);
        // $datasiswa=siswa::all();
        $no = 1;
        
        foreach($pembayaran as $k){
            $pdf::Cell(10,6,$no, 1,"","L");
            $pdf::cell(35,6,$k->registrasi1->no_registrasi,1,"","L");
            $pdf::cell(65,6,$$k->registrasi1->pasien->nama,1,"","L");
           
            $pdf::cell(65,6,$k->registrasi1->dokter->nama_dokter,1,"","L");
            $pdf::Cell(35,6,$k->registrasi1->poli->nama_poli,1,"","L");
            $pdf::Cell(35,6,tgl_indo($k->registrasi1->tgl_reg),1,"","L");
            $pdf::Cell(35,6,rupiah($k->total_transaksi),1,"","R");
            
            // $pdf::Cell(35,6,rupiah($x->qty * $x->fee_asisten),1,"","R");
            $pdf::Ln();
            
            $no++;
          }
        } 
        // closing retail
        
        if($pembayaran_retail){        
            $pdf::Cell(0,6,"Transaksi Retail : ",0,"","L");
            $pdf::Ln();
            
    
            $pdf::SetFont('Arial','B',10);
            $pdf::cell(10,6,"No",1,"","C");
            $pdf::cell(35,6,"No Reg",1,"","L");
            $pdf::cell(35,6,"Type Pasien",1,"","L");
            $pdf::cell(65,6,"Nama Pasien",1,"","L");
            $pdf::cell(35,6,"Tgl Lahir",1,"","L");
            $pdf::cell(65,6,"Keterangan",1,"","L");
            $pdf::cell(35,6,"Total Transaksi",1,"","L");
            
            $pdf::Ln();
            $pdf::SetFont("Arial","",10);
            // $datasiswa=siswa::all();
            $no = 1;
            
            foreach($pembayaran_retail as $k){
                if($k->registrasi_retail->jenis_registrasi_retail_id=='umum'){
                    $type_pasien = 'umum';
                    $nama_pasien = 'umum';
                    $tgl_lahir = "-";
                }else{
                    $type_pasien = 'pasien';
                     $nama_pasien = info_pasien_nama($k->registrasi_retail->pasien_id);
                    $tgl_lahir = tgl_indo(info_pasien_tgl_lahir($k->registrasi_retail->pasien_id));
                }
                      
                $pdf::Cell(10,6,$no, 1,"","L");
                $pdf::cell(35,6,$k->registrasi_retail->no_registrasi,1,"","L");
                $pdf::cell(35,6,$type_pasien,1,"","L");
               
                $pdf::cell(65,6,$nama_pasien,1,"","L");
                $pdf::Cell(35,6,$tgl_lahir,1,"","L");
                $pdf::Cell(65,6,$k->registrasi_retail->keterangan,1,"","L");
                $pdf::Cell(35,6,rupiah($k->total_transaksi),1,"","R");
                
                // $pdf::Cell(35,6,rupiah($x->qty * $x->fee_asisten),1,"","R");
                $pdf::Ln();
                
                $no++;
              }
            } 
            
        $pdf::Output();
        exit;

    }    
}
