<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLateNowOptionToPassportDelays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('passport_delays', function (Blueprint $table) {
            $table->integer('later_now_option')->default(null)->comment('1=now,2=later');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('passport_delays', function (Blueprint $table) {
            $table->dropColumn('later_now_option');
        });
    }
}
