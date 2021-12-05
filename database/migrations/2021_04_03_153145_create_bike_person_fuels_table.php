<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikePersonFuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_person_fuels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('type')->comment('1=bike wise, 2=person');
            $table->integer('status')->comment('1=checkin, 0=checkout');
            $table->bigInteger('bike_id');
            $table->bigInteger('passport_id');
            $table->dateTime('checkout')->nullable();
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
        Schema::dropIfExists('bike_person_fuels');
    }
}
