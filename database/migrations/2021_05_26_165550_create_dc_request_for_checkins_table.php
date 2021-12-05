<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDcRequestForCheckinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_request_for_checkins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('request_by_id');
            $table->bigInteger('approve_by_id')->nullable();
            $table->bigInteger('rider_passport_id');
            $table->bigInteger('platform_id');
            $table->bigInteger('city_id');
//            $table->bigInteger('dc_id')->nullable();
            $table->dateTime('checkin_date_time');
            $table->integer('rider_have_own_sim_and_bike')->default(0)->comment('0 means dont have both, 1= means have bike only, 2= means sim only, 3 means have both bike and sim');
            $table->text('remarks')->nullable();
            $table->integer('request_status')->default(0); //0 pending, 1= approved, 2=rejected
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
        Schema::dropIfExists('dc_request_for_checkins');
    }
}
