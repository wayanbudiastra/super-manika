<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Registrasi_retail extends Model
{
    //
    protected $table = 'registrasi_retail';
    protected $fillable = ['id',
    'no_registrasi',
    'pasien_id',
    'jenis_registrasi_retail_id',
    'tgl_reg',
    'periode',
    'keterangan',
    'aktif',
    'iscencel',
    'users_id',
    'created_at',
    'update_at'];

    public function pembayaran_retail()
    {
    	return $this->hasOne('App\model\Pembayaran\Pembayaran_retail');
    }
    
}
