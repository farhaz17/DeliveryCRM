<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPreviousCompanyToBikeVendorRiderOnboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_rider_onboards', function (Blueprint $table) {
            $table->string('previous_company')->nullable();
            $table->string('previous_platform')->nullable();
            $table->string('previous_rider_id')->nullable();
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
            $table->dropColumn(['previous_company', 'previous_platform', 'previous_rider_id']);
        });
    }
}
