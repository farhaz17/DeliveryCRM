<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRejectReasonToDcRequestForCheckins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dc_request_for_checkins', function (Blueprint $table) {
            $table->text('reject_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dc_request_for_checkins', function (Blueprint $table) {
            $table->dropColumn('reject_reason');
        });
    }
}
