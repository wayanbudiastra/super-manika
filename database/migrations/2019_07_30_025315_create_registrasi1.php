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
            $table->integer('pasien_id');
            $table->integer('jenis_registrasi_id')->nullable();
            $table->integer('poli_id');
            $table->integer('ruangan_id')->nullable();
            $table->integer('dokter_id');
            $table->integer('rujukan_id')->nullable();
            $table->date('tgl_reg');
            $table->string('periode');
            $table->integer('perawat_id')->nullable();
            $table->integer('terapis_id')->nullable();
            $table->integer('asdok_id')->nullable();
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
        Schema::dropIfExists('registrasi1');
    }
}
