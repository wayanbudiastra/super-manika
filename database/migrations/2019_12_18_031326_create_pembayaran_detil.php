<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaranDetil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran_detil', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->integer('pembayaran_id');
             $table->string('transaksi');
             $table->string('kode_item');
             $table->string('nama_item');
             $table->string('katagori_item');
             $table->integer('qty');
             $table->decimal('harga_jual',15,2);
             $table->decimal('payer_net',15,2)->nullable();
             $table->decimal('pasien_net',15,2)->nullable();
             $table->decimal('subtotal',15,2);
             $table->enum('aktif', ['Y', 'N'])->default('Y');
             $table->integer('users_id');
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
        Schema::dropIfExists('pembayaran_detil');
    }
}
