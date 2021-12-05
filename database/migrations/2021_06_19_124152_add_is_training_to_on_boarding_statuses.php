<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsTrainingToOnBoardingStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('on_boarding_statuses', function (Blueprint $table) {
            //
            $table->bigInteger('is_training')->default(0)->comment('0 means NO, 1 means YES');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('on_boarding_statuses', function (Blueprint $table) {
            //
            $table->dropColumn('is_training');
        });
    }
}
