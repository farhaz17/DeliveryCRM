<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrivingLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driving_licenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('license_number');
            $table->dateTime('issue_date');
            $table->dateTime('expire_date');
            $table->string('place_issue')->nullable();
            $table->bigInteger('traffic_code')->nullable();
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
        Schema::dropIfExists('driving_licenses');
    }
}
