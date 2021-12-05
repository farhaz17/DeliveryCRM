<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCareerIdToOnBoardingStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('on_boarding_statuses', function (Blueprint $table) {
            $table->integer('career_id')->default(null)->after('passport_id');

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
            $table->dropColumn('career_id');
        });
    }
}
