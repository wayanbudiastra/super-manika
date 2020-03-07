<?php

namespace App\model\Pembayaran;

use Illuminate\Database\Eloquent\Model;

class Kas_manual extends Model
{
    //
    protected $table = 'kas_manual';

    protected $fillable = [
        'id',
        'users_id',
        'kas_id',
        'transaksi',
        'kas_masuk',
        'kas_keluar',
        'keterangan',
        'aktif'
    ];

    public function kas()
    {
    	return $this->belongsTo('App\model\Pembayaran\Kas', 'kas_id');
    }
}
