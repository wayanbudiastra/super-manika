<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kas_id');
            $table->integer('registrasi1_id');
            $table->string('no_invoice')->nullable();
            $table->date('tgl_pembayaran');
            $table->decimal('total_transaksi', 15,2);
            $table->decimal('total_diskon', 15,2);
            $table->decimal('total_kembali', 15,2);
            $table->decimal('total_pembayaran', 15,2);
            $table->decimal('kurang_bayar', 15,2)->nullable();
            $table->integer('invoice')->nullable();
            $table->enum('aktif', ['Y', 'N'])->default('Y');
            $table->enum('cencel', ['Y', 'N'])->default('N');
            $table->enum('posting',['Y','N'])->default('N');
            $table->integer('users_id');
            $table->enum('closing',['Y','N'])->default('N');
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
        Schema::dropIfExists('pembayaran');
    }
}
