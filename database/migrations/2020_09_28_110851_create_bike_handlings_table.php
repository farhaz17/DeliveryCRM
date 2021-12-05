<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBikeHandlingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bike_handlings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id')->nullable();
            $table->string('full_name')->nullable();
            $table->bigInteger('nationality')->nullable();
            $table->date('dob')->nullable();
            $table->string('emirates_id')->nullable();
            $table->date('emirates_issue_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->string('license_number')->nullable();
            $table->string('place_issue')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->string('company')->nullable();
            $table->string('model_year')->nullable();
            $table->string('type')->nullable();
            $table->string('plate_no')->nullable();
            $table->string('color')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('dep_date')->nullable();
            $table->dateTime('exp_date')->nullable();
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
        Schema::dropIfExists('bike_handlings');
    }
}
