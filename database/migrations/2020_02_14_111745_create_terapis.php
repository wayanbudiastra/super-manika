<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTerapis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terapis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id');
            $table->string('nik');
            $table->string('nama_terapis');
            $table->string('email');
            $table->string('no_telp');
            $table->text('alamat');
            $table->string('tgl_lahir');
            $table->string('tempat_lahir');
            $table->enum('aktif', ['Y', 'N'])->default('Y');
            $table->softDeletes()->default(null);
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
        Schema::dropIfExists('terapis');
    }
}
