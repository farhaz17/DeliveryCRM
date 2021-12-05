<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToAccidentRiderRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accident_rider_requests', function (Blueprint $table) {
            $table->bigInteger('data_from')->after('status')->comment('1=vehicle_accident');
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
