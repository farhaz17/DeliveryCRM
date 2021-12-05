<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLpoVehicleInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpo_vehicle_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lpo_id')->nullable();
            $table->integer('model_id')->nullable();
            $table->text('make_year')->nullable();
            $table->text('chassis_no')->nullable();
            $table->text('engine_no')->nullable();
            $table->text('plate_no')->nullable();
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
        Schema::dropIfExists('lpo_vehicle_infos');
    }
}
