<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInterviewIdToOnBoardingStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('on_boarding_statuses', function (Blueprint $table) {
            $table->integer('create_interview_id')->nullable()->after('assign_platform');
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
            $table->dropColumn('create_interview_id');
        });
    }
}
