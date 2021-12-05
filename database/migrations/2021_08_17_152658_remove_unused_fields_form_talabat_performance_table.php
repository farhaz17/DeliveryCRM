<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnusedFieldsFormTalabatPerformanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('talabat_rider_performances', function (Blueprint $table) {
            $table->dropColumn([
                'completion_rate_percentage',
                'undispatch_count',
                'avg_delivery_time',
                'avg_at_vendor_time',
                'avg_at_customer_time',
                'avg_to_customer_time',
                'avg_to_vendor_time',
                'pick_up_gps_error_percentage',
                'drop_off_gps_error_percentage'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('talabat_rider_performances', function (Blueprint $table) {
        });
    }
}
