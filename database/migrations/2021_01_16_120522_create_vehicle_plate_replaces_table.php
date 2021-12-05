<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclePlateReplacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_plate_replaces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('plate_no')->nullable();
            $table->string('reson_of_replacement')->nullable();
            $table->string('remarks')->nullable();
            $table->json('attachment_labels')->nullable();
            $table->json('attachment_paths')->nullable();
            $table->integer('status')->default(0)->nullable()->comment('0 = requested, 1 = approved, 2 = rejected');
            $table->softdeletes();
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
        Schema::dropIfExists('vehicle_plate_replaces');
    }
}
