<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');  //passport_id
            $table->string('agreement_no');
            $table->bigInteger('reference_type'); //own = 0,outside = 1
            $table->string('reference_type_own')->nullable(); //passport_id , here will come rider user id
            $table->text('reference_type_outside')->nullable(); //json format
            $table->bigInteger('current_status_id');
            $table->dateTime('current_status_start_date')->nullable();
            $table->dateTime('current_status_end_date')->nullable(); //expected data will be end data for waiting for cancellation type
            $table->bigInteger('working_visa');
            $table->bigInteger('applying_visa')->nullable();
            $table->bigInteger('working_designation');
            $table->bigInteger('visa_designation');
            $table->bigInteger('driving_licence'); // yes = 0, no =1
            $table->bigInteger('driving_licence_ownership')->nullable(); //company =0 ,own =1
            $table->bigInteger('driving_licence_vehicle')->nullable(); //car =0 ,bike =1
            $table->bigInteger('driving_licence_vehicle_type')->nullable(); //manual =0 ,auto =1
            $table->bigInteger('medical_ownership')->nullable(); //company =0 ,own =1
            $table->bigInteger('medical_ownership_type')->nullable(); //medical status id
            $table->bigInteger('emiratesid_ownership'); //company =0 ,own =1
            $table->bigInteger('status_change'); //inside =0 ,in-out =1
            $table->bigInteger('employee_type_id');
            $table->bigInteger('living_status_id');
            $table->float('discount')->nullable();
            $table->bigInteger('fine'); //company =0 ,own =1
            $table->bigInteger('rta_permit'); //company =0 ,own =1
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
        Schema::dropIfExists('agreements');
    }
}
