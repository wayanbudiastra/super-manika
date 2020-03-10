<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('tgl_open');
            $table->date('tgl_close')->nullable();
            $table->decimal('kas_awal', 15,2);
            $table->decimal('total_tunai', 15,2);
            $table->decimal('total_debit', 15,2);
            $table->decimal('total_kredit', 15,2);
            $table->decimal('total_lain', 15,2);
            $table->decimal('total_transaksi', 15,2);
            $table->decimal('total_kembali', 15,2);
            $table->decimal('kas_akhir', 15,2);
            $table->integer('users_id');
            $table->text('keterangan');
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
        Schema::dropIfExists('kas');
    }
}
