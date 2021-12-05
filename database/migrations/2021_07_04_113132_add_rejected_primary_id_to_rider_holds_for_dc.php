<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRejectedPrimaryIdToRiderHoldsForDc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rider_holds_for_dc', function (Blueprint $table) {

            $table->bigInteger('rejected_primary_id')->nullable()->after('request_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rider_holds_for_dc', function (Blueprint $table) {
            //
            $table->dropColumn('rejected_primary_id');
        });
    }
}
