<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnSimBikeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('own_sim_bike_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('own_type'); //1=sim , 2=bike
            $table->bigInteger('platform_id');
            $table->bigInteger('passport_id');
            $table->dateTime('checkin');
            $table->dateTime('checkout')->nullable();
            $table->integer('status'); //1= have own bike, 0= don't have bike
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
        Schema::dropIfExists('own_sim_bike_histories');
    }
}
