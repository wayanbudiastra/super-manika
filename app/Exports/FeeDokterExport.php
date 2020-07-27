<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class FeeDokterExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $tgl_mulai;
    protected $tgl_selesai;
    protected $dokter_id;

    function __construct($tgl_mulai,$tgl_selesai,$dokter_id) {
        $this->tgl_mulai = $tgl_mulai;
        $this->tgl_selesai = $tgl_selesai;
        $this->dokter_id = $dokter_id;
    }

    public function collection()
    {
        //
        $data = DB::table('pembayaran_detil')
        ->select(
            'pembayaran.no_invoice',
            'registrasi1.no_registrasi',
            'dokter.nama_dokter',
            'pembayaran_detil.transaksi',
            'pembayaran.tgl_pembayaran',   
            'pembayaran_detil.nama_item',
            'pembayaran_detil.qty',
            'pembayaran_detil.fee_dokter')
        ->join('pembayaran','pembayaran_detil.pembayaran_id','pembayaran.id')
        ->join('registrasi1','pembayaran.registrasi1_id','registrasi1.id')
        ->join('dokter','registrasi1.dokter_id','dokter.id')
        ->whereBetween('pembayaran.tgl_pembayaran',[$this->tgl_mulai, $this->tgl_selesai])
        ->where('registrasi1.dokter_id',$this->dokter_id)
        ->where('pembayaran_detil.aktif','N')
        ->get();

        return $data;
    }
}
