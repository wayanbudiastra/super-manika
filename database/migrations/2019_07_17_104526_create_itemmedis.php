<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemmedis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemmedis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode');
            $table->string('nm_item');
            $table->integer('satuanbesar')->nullable();
            $table->integer('satuankecil')->nullable();
            $table->integer('isi')->nullable();
            $table->integer('katagoriitemmedis_id')->nullable();
            $table->integer('typeitemmedis_id')->nullable();
            $table->decimal('hargabeli', 15,2)->nullable();
            $table->decimal('feedokter', 15,2)->nullable();
            $table->decimal('feenurse', 15,2)->nullable();
            $table->decimal('feelainnya', 15,2)->nullable();
            $table->decimal('hargajual', 15,2)->nullable();
            $table->decimal('markup', 15,2)->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('stok')->nullable();
            $table->integer('stok_max')->nullable();
            $table->integer('stok_min')->nullable();
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
        Schema::dropIfExists('itemmedis');
    }
}
