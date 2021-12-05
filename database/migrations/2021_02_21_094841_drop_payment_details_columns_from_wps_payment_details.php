<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPaymentDetailsColumnsFromWpsPaymentDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wps_payment_details', function (Blueprint $table) {
            $table->dropColumn(['payment_method','payment_method_details','by_hand_id','active']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wps_payment_details', function (Blueprint $table) {
            $table->string('payment_method')->nullable();
            $table->string('payment_method_details')->nullable();
            $table->string('by_hand_id')->nullable();
            $table->string('active')->nullable();
        });
    }
}
