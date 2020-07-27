<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class FeeAsistenExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $tgl_mulai;
    protected $tgl_selesai;
    protected $asdok_id;

    function __construct($tgl_mulai,$tgl_selesai,$asdok_id) {
        $this->tgl_mulai = $tgl_mulai;
        $this->tgl_selesai = $tgl_selesai;
        $this->asdok_id = $asdok_id;
    } 

    public function collection()
    {
        //
        $data = DB::table('pembayaran_detil')
        ->select(
            'pembayaran.no_invoice',
            'registrasi1.no_registrasi',
            'asdok.nama_asdok',
            'pembayaran_detil.transaksi',
            'pembayaran.tgl_pembayaran',   
            'pembayaran_detil.nama_item',
            'pembayaran_detil.qty',
            'pembayaran_detil.fee_asisten')
        ->join('pembayaran','pembayaran_detil.pembayaran_id','pembayaran.id')
        ->join('registrasi1','pembayaran.registrasi1_id','registrasi1.id')
        ->join('asdok','registrasi1.asdok_id','asdok.id')
        ->whereBetween('pembayaran.tgl_pembayaran',[$this->tgl_mulai, $this->tgl_selesai])
        ->where('registrasi1.asdok_id',$this->asdok_id)
        ->where('pembayaran_detil.aktif','N')
        ->get();

        return $data;

    }
}
