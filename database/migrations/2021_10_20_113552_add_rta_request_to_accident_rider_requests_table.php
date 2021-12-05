<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRtaRequestToAccidentRiderRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accident_rider_requests', function (Blueprint $table) {
            $table->bigInteger('rta_request')->nullable();
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
            $table->dropColumn('rta_request');
        });
    }
}
