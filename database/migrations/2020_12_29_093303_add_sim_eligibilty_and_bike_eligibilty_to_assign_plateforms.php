<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSimEligibiltyAndBikeEligibiltyToAssignPlateforms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assign_plateforms', function (Blueprint $table) {
            $table->bigInteger('sim_eligibility')->nullable();
            $table->bigInteger('bike_eligibility')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assign_plateforms', function (Blueprint $table) {
            $table->dropColumn(['sim_eligibility','bike_eligibility']);
        });
    }
}
