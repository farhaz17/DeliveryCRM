<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikeReplacementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_replacements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->bigInteger('assign_bike_id');  //assign bike table id
            $table->bigInteger('replace_bike_id');
            $table->bigInteger('new_bike_id');
            $table->Integer('type'); // 1 = temporary , 2 = permanent
            $table->Integer('replace_reason');
            $table->Integer('status'); // 1 = checkin, 0 = checkout
            $table->text('replace_remarks')->nullable();
            $table->text('replace_taken_remarks')->nullable();
            $table->dateTime('replace_checkin');
            $table->dateTime('replace_checkout')->nullable();
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
        Schema::dropIfExists('bike_replacements');
    }
}
