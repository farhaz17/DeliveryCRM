<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCashOrExchangeToWpsPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wps_payment_details', function (Blueprint $table) {
            $table->integer('cash_or_exchange')->nullable(); //1-cash 2-exchange
            $table->string('wps_payment_type')->nullable();
            $table->integer('wps_payment_id')->nullable();
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
            $table->dropColumn(['cash_or_exchange','wps_payment_type','wps_payment_id']);
        });
    }
}
