<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewVisaPaymentOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renew_visa_payment_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->integer('renew_step');
            $table->double('payment_amount');
            $table->double('fine_amount');
            $table->bigInteger('payment_type');
            $table->string('transaction_no');
            $table->dateTime('transaction_date_time');
            $table->double('vat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('renew_visa_payment_options');
    }
}
