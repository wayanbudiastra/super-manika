<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrasiRetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrasi_retail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no_registrasi')->unique();
            $table->string('pasien_id');
            $table->integer('jenis_registrasi_retail_id')->nullable();
            $table->date('tgl_reg');
            $table->string('periode');
            $table->text('keterangan')->nullable();
            $table->enum('aktif',['Y','N'])->default('Y');
            $table->enum('iscencel',['Y','N'])->default('N');
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
        Schema::dropIfExists('registrasi_retail');
    }
}
