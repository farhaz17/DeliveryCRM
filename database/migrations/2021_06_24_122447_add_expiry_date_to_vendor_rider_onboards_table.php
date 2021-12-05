<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExpiryDateToVendorRiderOnboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_rider_onboards', function (Blueprint $table) {
            $table->date('passport_expiry')->nullable();
            $table->date('visa_expiry')->nullable();
            $table->date('emirates_expiry')->nullable();
            $table->date('driving_license_expiry')->nullable();
            $table->date('mulkiya_expiry')->nullable();
            $table->date('insurance_expiry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor_rider_onboards', function (Blueprint $table) {
            $table->dropColumn(['passport_expiry', 'visa_expiry', 'emirates_expiry', 'driving_license_expiry', 'mulkiya_expiry', 'insurance_expiry']);
        });
    }
}
