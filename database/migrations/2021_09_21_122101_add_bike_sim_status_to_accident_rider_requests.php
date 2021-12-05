<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBikeSimStatusToAccidentRiderRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accident_rider_requests', function (Blueprint $table) {
            //
            $table->integer('bike_sim_approve_status')->default(0)->comment('0=pending,1=accepted');
            $table->bigInteger('bike_sim_approve_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accident_rider_requests', function (Blueprint $table) {
            //
        });
    }
}
