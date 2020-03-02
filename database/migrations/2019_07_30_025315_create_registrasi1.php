<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrasi1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrasi1', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_registrasi');
            $table->integer('jenis_registrasi_id')->nullable();
            $table->integer('poli_id');
            $table->integer('ruangan_id')->nullable();
            $table->integer('dokter_id');
            $table->integer('rujukan_id')->nullable();
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
        Schema::dropIfExists('registrasi1');
    }
}
