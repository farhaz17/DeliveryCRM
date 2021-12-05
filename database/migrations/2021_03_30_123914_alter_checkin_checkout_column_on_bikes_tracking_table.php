<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCheckinCheckoutColumnOnBikesTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bikes_trackings', function (Blueprint $table) {
            $table->datetime('checkin')->change();
            $table->datetime('checkout')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bikes_trackings', function (Blueprint $table) {
            $table->date('checkin')->change();
            $table->date('checkout')->change();
        });
    }
}
