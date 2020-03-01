<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubSpesialis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_spesialis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('spesialis_id');
            $table->string('nama_subspesialis');
            $table->text('keterangan')->nullable();
            $table->enum('aktif',['Y','N'])->defaulft('Y');
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
        Schema::dropIfExists('sub__spesialis');
    }
}
