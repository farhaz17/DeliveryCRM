<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorRiderOnboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_rider_onboards', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('rider_first_name');
            $table->string('rider_last_name');
            $table->string('contact_official');
            $table->bigInteger('contacts_personal');
            $table->string('four_pl_name');
            $table->string('four_pl_code');
            $table->string('emirates_id_no');
            $table->string('passport_no');
            $table->string('driving_license_no');
            $table->string('plate_no');
            $table->integer('nationality');
            $table->date('dob');
            $table->string('city');
            $table->string('address');
            $table->string('passport_copy');
            $table->string('visa_copy');
            $table->string('emirates_id_front_side');
            $table->string('emirates_id_front_back');
            $table->string('driving_license_front');
            $table->string('driving_license_back');
            $table->string('health_insurance_card_copy');
            $table->string('rider_photo');
            $table->string('status');
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
        Schema::dropIfExists('vendor_rider_onboards');
    }
}
