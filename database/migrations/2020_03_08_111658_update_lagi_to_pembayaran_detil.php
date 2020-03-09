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
            $table->decimal('diskon')->nullable();
            $table->decimal('fee_dokter')->nullable();
            $table->decimal('fee_asisten')->nullable();
            $table->decimal('fee_staff')->nullable();
            $table->decimal('fee_terapis')->nullable();
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
