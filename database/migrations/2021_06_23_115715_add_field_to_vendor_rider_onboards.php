<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldToVendorRiderOnboards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor_rider_onboards', function (Blueprint $table) {
            $table->integer('vaccine')->nullable()->comments('1 for vaccine taken, 2 for not taken');
            $table->integer('vaccine_dose')->nullable()->comments('1 for 1st dose only, 2 for 2nd dose completed');
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
            $table->dropColumn([
                'vaccine',
                'vaccine_dose'
            ]);
        });
    }
}
