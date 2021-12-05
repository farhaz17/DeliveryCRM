<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRtaVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rta_vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('mortgaged_by')->nullable();
            $table->string('insurance_co');
            $table->string('expiry_date');
            $table->string('issue_date');
            $table->string('fines_amount');
            $table->string('number_of_fines');
            $table->string('registration_valid_for_days');
            $table->string('make_year');
            $table->string('plate_no');
            $table->string('chassis_no');
            $table->string('model');
            $table->string('traffic_file_number');
            $table->string('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rta_vehicles');
    }
}
