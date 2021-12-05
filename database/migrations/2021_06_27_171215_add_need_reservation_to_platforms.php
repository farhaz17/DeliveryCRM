<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNeedReservationToPlatforms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('platforms', function (Blueprint $table) {
            //
            $table->integer('need_reservation')->default(0)->comment('0 means No, 1 means Yes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('platforms', function (Blueprint $table) {
            //
            $table->dropColumn('need_reservation');
        });
    }
}
