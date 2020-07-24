<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class PendapatanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $tgl_mulai;
    protected $tgl_selesai;

    function __construct($tgl_mulai,$tgl_selesai) {
        $this->tgl_mulai = $tgl_mulai;
        $this->tgl_selesai = $tgl_selesai;
    }

    public function collection()
    {
        //
        $data = DB::table('pembayaran_detil')
        ->select(
        'pembayaran.no_invoice',
        'pembayaran_detil.transaksi',
        'pembayaran.tgl_pembayaran',   
        'pembayaran_detil.nama_item',
        'pembayaran_detil.harga_jual',
        'pembayaran_detil.qty',
        'pembayaran_detil.subtotal')
        ->join('pembayaran','pembayaran_detil.pembayaran_id','pembayaran.id')
        ->whereBetween('pembayaran.tgl_pembayaran',[$this->tgl_mulai, $this->tgl_selesai]) 
        ->where('pembayaran_detil.aktif','N')
        ->get();
       
        return $data;
    }
}
