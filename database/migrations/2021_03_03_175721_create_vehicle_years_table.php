<?php

use App\Model\BikeDetail;
use Illuminate\Support\Facades\Schema;
use App\Model\Master\Vehicle\VehicleYear;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleYearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_years', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->year('year');
            $table->softDeletes();
            $table->timestamps();
        });

        // Update existing Data
        $bike_details = BikeDetail::all();

        foreach($bike_details as $bike_detail){

            if($bike_detail->make_year !== null){
                $bike_detail->make_year = VehicleYear::updateOrCreate(
                [
                    'year' => $bike_detail->make_year
                ],[
                    'year' => $bike_detail->make_year,
                ])->id;
                $bike_detail->update();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_years');
    }
}
