<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLagiToPembayaranDetil extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pembayaran_detil', function (Blueprint $table) {
            //
            $table->decimal('diskon',15,2)->nullable();
            $table->decimal('fee_dokter',15,2)->nullable();
            $table->decimal('fee_asisten',15,2)->nullable();
            $table->decimal('fee_staff',15,2)->nullable();
            $table->decimal('fee_terapis',15,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pembayaran_detil', function (Blueprint $table) {
            //
        });
    }
}
