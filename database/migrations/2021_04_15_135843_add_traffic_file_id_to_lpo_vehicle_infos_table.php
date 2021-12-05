<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTrafficFileIdToLpoVehicleInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lpo_vehicle_infos', function (Blueprint $table) {
            $table->integer('traffic_file_id')->nullable();
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
            $table->dropColumn('traffic_file_id');
        });
    }
}
