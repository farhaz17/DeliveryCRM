<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fuels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rid');
            $table->string('vehicle_plate_number');
            $table->string('license_plate_nr');
            $table->string('sale_end');
            $table->string('unit_price');
            $table->string('volume');
            $table->string('total');
            $table->string('product_name');
            $table->string('receipt_nr');
            $table->string('odometer');
            $table->string('id_unit_code');
            $table->string('station_name');
            $table->string('station_code');
            $table->string('fleet_name');
            $table->string('p_product_name');
            $table->string('group_name');
            $table->string('vehicle_code');
            $table->string('city_code');
            $table->string('cost_center');
            $table->string('vat_rate');
            $table->string('vat_amount');
            $table->string('actual_amount');
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
        Schema::dropIfExists('fuels');
    }
}
