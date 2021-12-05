<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleStatusChangeHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_status_change_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('bike_id');
            $table->date('change_date');
            $table->integer('status_change_form');
            $table->integer('status_change_to');
            $table->integer('changed_by');
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('vehicle_status_change_history');
    }
}
