<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccidentRiderRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accident_rider_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('dc_id');
            $table->bigInteger('rider_passport_id');
            $table->integer('checkout_type')->nullable();
            $table->integer('request_type')->comment("1=complete checkout, 2=only bike replacement");
            $table->dateTime('checkout_date')->nullable();
            $table->bigInteger('team_leader_id');
            $table->bigInteger('bike_id');
            $table->bigInteger('sim_id');
            $table->text('remarks')->nullable();
            $table->bigInteger('status')->default(0);
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
        Schema::dropIfExists('accident_rider_requests');
    }
}
