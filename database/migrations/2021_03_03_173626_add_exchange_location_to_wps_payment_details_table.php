<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExchangeLocationToWpsPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wps_payment_details', function (Blueprint $table) {
            $table->string('exchange_location')->after('cash_or_exchange')->nullable(); //1-cash 2-exchange
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
            $table->dropColumn('exchange_location');
        });
    }
}
