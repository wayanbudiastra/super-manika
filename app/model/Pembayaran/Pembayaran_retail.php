<?php

namespace App\model\Pembayaran;

use Illuminate\Database\Eloquent\Model;

class Pembayaran_retail extends Model
{
    //
    protected $table = 'pembayaran_retail';

        protected $fillable = [
            'id',
            'kas_id',
            'tgl_pembayaran',
            'no_invoice',
            'registrasi_retail_id',
            'total_transaksi',
            'total_diskon',
            'total_kembali',
            'total_pembayaran',
            'kurang_bayar',
            'invoice',
            'closing',
            'posting',
            'users_id',
            'cencel',
            'remember_token',
            'aktif'
        ];
    public function registrasi_retail()
    {
    	return $this->belongsTo('App\model\Registrasi_retail');
    }
}
