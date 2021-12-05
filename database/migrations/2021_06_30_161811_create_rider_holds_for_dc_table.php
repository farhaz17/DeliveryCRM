<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiderHoldsForDcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_holds_for_dc', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('assign_platform_id')->comment('primary id of assign_platforms');;
            $table->bigInteger('dc_request_for_checkin_id')->comment('dc_id that select by team leader');
            $table->bigInteger('dc_id')->comment('primary id of dc_request_for_checkins');
            $table->integer('request_status')->default(0)->comment('0 means pending, 1 means accepted, 2 means rejected');
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
        Schema::dropIfExists('rider_holds_for_dc');
    }
}
