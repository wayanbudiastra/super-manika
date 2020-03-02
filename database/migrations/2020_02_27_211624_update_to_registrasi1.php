<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateToRegistrasi1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('registrasi1', function (Blueprint $table) {
            //
            $table->integer('pasien_id');
             $table->date('tgl_reg');
             $table->string('periode');
            $table->integer('perawat_id')->nullable();
            $table->integer('terapis_id')->nullable();
            $table->integer('asdok_id')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('aktif',['Y','N'])->default('Y');
            $table->enum('iscencel',['Y','N'])->default('N');
            $table->integer('users_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registrasi1', function (Blueprint $table) {
            //
        });
    }
}
