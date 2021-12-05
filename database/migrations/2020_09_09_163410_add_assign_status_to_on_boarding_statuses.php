<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssignStatusToOnBoardingStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('on_boarding_statuses', function (Blueprint $table) {
            $table->Integer('sim_assign')->nullable(); //null no sim assign, 1 means no sim assign , 0 means sim assign
            $table->Integer('bike_assign')->nullable(); //null no bike assign, 1 means no bike assign , 0 means bike assign
            $table->Integer('interview_status')->nullable(); //interview status, 1 means he is eligible for on board
            $table->Integer('applicant_status')->nullable(); // career interview status, 0 ,means he is passed, 1 means he is eligible for on board
            $table->text('platform_ids')->nullable();  // which platform he wants to work
            $table->integer('assign_platform')->nullable(); // null means not platform assign, 1 means no assign platform, 2 means 2 this rider have one platform assigned
            $table->integer('exist_user')->nullable(); // came direct from platform check out, 1 means eligible for android, 0 means not assigned
            $table->integer('on_board')->nullable(); // 0 = this uer is hired , null , 1 means eligible for on board
            //
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
        });
    }
}
