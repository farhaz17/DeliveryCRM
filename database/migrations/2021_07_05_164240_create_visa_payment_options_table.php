<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisaPaymentOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_payment_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id')->nullable();
            $table->bigInteger('visa_process_step_id')->nullable();
            $table->double('payment_amount')->nullable();
            $table->bigInteger('payment_type')->nullable();
            $table->string('transaction_no')->nullable();
            $table->datetime('transaction_date_time')->nullable();
            $table->double('vat')->nullable();
            $table->text('other_attachment')->nullable();

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
        Schema::dropIfExists('visa_payment_options');
    }
}
