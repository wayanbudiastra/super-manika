<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKasManual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kas_manual', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('kas_id');
            $table->string('transaksi');
            $table->decimal('kas_masuk',15,2);
            $table->decimal('kas_keluar',15,2);
            $table->text('keterangan')->nullable();
            $table->integer('users_id');
            $table->enum('aktif',['Y','N'])->default('Y');
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
        Schema::dropIfExists('kas_manual');
    }
}
