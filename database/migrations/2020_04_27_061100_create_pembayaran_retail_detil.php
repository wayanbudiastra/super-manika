<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaranRetailDetil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_retail_detil', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->integer('pembayaran_retail_id');
            $table->string('transaksi');
            $table->string('kode_item');
            $table->string('nama_item');
            $table->string('katagori_item');
            $table->string('qty');
            $table->decimal('harga_jual',15,2);
            $table->decimal('payer_net',15,2)->nullable();
            $table->decimal('pasien_net',15,2)->nullable();
            $table->decimal('subtotal',15,2);
            $table->enum('aktif',['Y','N'])->default('Y');
            $table->decimal('diskon',15,2)->nullable();
            $table->decimal('fee_dokter',15,2)->nullable();
            $table->decimal('fee_asisten',15,2)->nullable();
            $table->decimal('fee_staff',15,2)->nullable();
            $table->decimal('fee_terapis',15,2)->nullable();
            $table->rememberToken()->unique();
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
        Schema::dropIfExists('pembayaran_retail_detil');
    }
}
