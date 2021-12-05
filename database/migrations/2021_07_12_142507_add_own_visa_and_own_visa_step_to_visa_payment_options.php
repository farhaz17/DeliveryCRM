<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOwnVisaAndOwnVisaStepToVisaPaymentOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('visa_payment_options', function (Blueprint $table) {
            //
            $table->integer('own_visa')->nullable();
            $table->integer('own_visa_step')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('visa_payment_options', function (Blueprint $table) {
            //
        });
    }
}
