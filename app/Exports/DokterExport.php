<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;

class DokterExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        $data = DB::table('dokter')->select(
            'dokter.nik',
            'dokter.nama_dokter',
            'dokter.tempat_lahir',
            'dokter.tgl_lahir',
            'dokter.email',
            'dokter.alamat',
            'dokter.no_telp',
            'dokter.aktif',
            'spesialis.nama_spesialis',
            'sub_spesialis.nama_subspesialis'
        )
        ->join('spesialis', 'dokter.spesialis_id','spesialis.id')
        ->join('sub_spesialis','dokter.subspesialis_id','sub_spesialis.id')
        ->get();

        return $data;
    }
}
