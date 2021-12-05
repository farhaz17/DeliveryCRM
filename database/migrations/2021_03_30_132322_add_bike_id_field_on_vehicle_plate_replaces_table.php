<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBikeIdFieldOnVehiclePlateReplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehicle_plate_replaces', function (Blueprint $table) {
            $table->integer('bike_id')->nullable()->after('id');
            $table->string('new_plate_no')->nullable()->after('plate_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehicle_plate_replaces', function (Blueprint $table) {
            $table->dropColumn(['bike_id','new_plate_no']);
        });
    }
}
