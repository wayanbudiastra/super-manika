<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateToPoli extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('poli', function (Blueprint $table) {
            //
            $table->renameColumn('nm_poli', 'nama_poli');
            $table->dropColumn('id_praktek');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poli', function (Blueprint $table) {
            //
        });
    }
}
