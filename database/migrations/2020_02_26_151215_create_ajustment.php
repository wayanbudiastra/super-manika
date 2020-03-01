<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAjustment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ajustment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('produk_id');
            $table->date('tgl_ajustment');
            $table->string('jenis_ajustment');
            $table->integer('qty_in')->nullable();
            $table->integer('qty_out')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('ajustment');
    }
}
