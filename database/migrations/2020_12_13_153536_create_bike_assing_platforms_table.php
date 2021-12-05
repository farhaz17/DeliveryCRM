<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikeAssingPlatformsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_assing_platforms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('platform_id');
            $table->bigInteger('bike_id');
            $table->Integer('status');
            $table->dateTime('checkin');
            $table->dateTime('checkout')->nullable();
            $table->text('remarks')->nullable();
            $table->text('checkout_remarks')->nullable();
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
        Schema::dropIfExists('bike_assing_platforms');
    }
}
