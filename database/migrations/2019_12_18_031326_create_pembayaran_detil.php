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
             $table->decimal('harga_jual');
             $table->decimal('diskon')->nullable();
             $table->decimal('payer_net')->nullable();
             $table->decimal('pasien_net')->nullable();
             $table->decimal('subtotal');
             $table->decimal('fee_dokter')->nullable();
             $table->decimal('fee_asisten')->nullable();
             $table->decimal('fee_staff')->nullable();
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
