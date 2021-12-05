<?php

use App\Model\BikeDetail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Model\Master\Vehicle\VehicleModel;
use App\Model\Master\Vehicle\VehicleMortgage;
use Illuminate\Database\Migrations\Migration;
use App\Model\Master\Vehicle\VehicleInsurance;
use App\Model\Master\Vehicle\VehiclePlateCode;

class AddFieldsToBikeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bike_details', function (Blueprint $table) {
            $table->string('rental_type')->nullable();
            $table->string('insurance_no')->nullable();
            $table->date('insurance_issue_date')->nullable();
            $table->date('insurance_expiry_date')->nullable();;
            $table->integer('vehicle_mortgage_no')->nullable();
            // $table->softDeletes();
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
            $table->dropColumn(['rental_type','insurance_no','insurance_issue_date','insurance_expiry_date','vehicle_mortgage_no']);
        });
    }
}
