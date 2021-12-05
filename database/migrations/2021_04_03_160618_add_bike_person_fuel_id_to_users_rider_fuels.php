<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBikePersonFuelIdToUsersRiderFuels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rider_fuels', function (Blueprint $table) {
            $table->bigInteger('bike_person_fuel_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rider_fuels', function (Blueprint $table) {
            $table->dropColumn(['bike_person_fuel_id']);
        });
    }
}
