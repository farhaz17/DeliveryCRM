<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedUserToLpoVehicleInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lpo_vehicle_infos', function (Blueprint $table) {
            $table->integer('created_user_id')->after('plate_no')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lpo_vehicle_infos', function (Blueprint $table) {
            $table->dropColumn('created_user_id');
        });
    }
}
