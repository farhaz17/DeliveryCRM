<?php

use App\Model\BikeDetail;
use Illuminate\Support\Facades\Schema;
use App\Model\Master\Vehicle\VehicleYear;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMakeFieldToBikeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_details', function (Blueprint $table) {
            $table->Integer('make_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bike_details', function (Blueprint $table) {
            $table->dropColumn(['make_id']);
        });
    }
}
