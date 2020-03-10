<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJasa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jasa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode');
            $table->string('nama_jasa');
            $table->string('jasakatagori_id');
            $table->decimal('harga_jual',15,2);
            $table->decimal('fee_dokter',15,2)->nullable();
            $table->decimal('fee_asisten',15,2)->nullable();
            $table->decimal('fee_staff',15,2)->nullable();
            $table->decimal('fee_terapis',15,2)->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('aktif', ['Y', 'N'])->default('Y');
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
        Schema::dropIfExists('jasa');
    }
}
