<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssignBikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_bikes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->string('bike');
            $table->dateTime('checkin');
            $table->dateTime('checkout')->nullable();
            $table->text('remarks')->nullable();
            $table->string('bike_images')->nullable();
            $table->bigInteger('status')->default('0');
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
        Schema::dropIfExists('assign_bikes');
    }
}
