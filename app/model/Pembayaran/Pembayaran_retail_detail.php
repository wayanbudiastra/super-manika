<?php

namespace App\model\Pembayaran;

use Illuminate\Database\Eloquent\Model;

class Pembayaran_retail_detail extends Model
{
    //
     protected $table = 'pembayaran_retail_detil';

        protected $fillable = [
            'id',
            'pembayaran_retail_id',
            'transaksi',
            'kode_item',
            'nama_item',
            'katagori_item',
            'qty',
            'diskon',
            'harga_jual',
            'payer_net',
            'pasien_net',
            'subtotal',
            'fee_dokter',
            'fee_asisten',
            'fee_staff',
            'fee_terapis',
            'remember_token',
            'aktif',
            'users_id'
        ];
}
