<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKasDetil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kas_detil', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kas_id');
            $table->date('tgl_transaksi');
            $table->string('transaksi');
            $table->decimal('total_tunai', 15,2);
            $table->decimal('total_debit', 15,2);
            $table->decimal('total_kredit', 15,2);
            $table->decimal('total_lainya', 15,2);
            $table->decimal('total_pembayaran', 15,2);
            $table->decimal('total_kembali', 15,2);
            $table->decimal('total_diskon', 15,2);
            $table->decimal('kurang_bayar', 15,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kas_detil');
    }
}
