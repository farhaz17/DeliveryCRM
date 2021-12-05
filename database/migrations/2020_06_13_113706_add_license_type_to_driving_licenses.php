<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLicenseTypeToDrivingLicenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('driving_licenses', function (Blueprint $table) {
            $table->Integer('license_type')->nullable();  // 1 = Bike, 2 = Car
            $table->Integer('car_type')->nullable(); // 1= Automatic , 2 = Manual
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('driving_licenses', function (Blueprint $table) {
            //
        });
    }
}
