<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReserveStatusToTelecomes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('telecomes', function (Blueprint $table) {
            $table->integer('reserve_status')->default(0); // 1 = click on alert
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('telecomes', function (Blueprint $table) {
            //
        });
    }
}
