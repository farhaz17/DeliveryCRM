<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReturnFromOnboardToCreateInterview extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('create_interviews', function (Blueprint $table) {
            //
            $table->bigInteger('return_from_onboard')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('create_interviews', function (Blueprint $table) {
            //
            $table->dropColumn('return_from_onboard');
        });
    }
}
