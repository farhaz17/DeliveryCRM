<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewalVisaStampingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewal_visa_stampings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->double('visa_stamping_payment_option');
            $table->text('attachment')->nullable();
            $table->double('payment_amount')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('transaction_no')->nullable();
            $table->string('transaction_date_time')->nullable();
            $table->string('vat')->nullable();
            $table->text('other_attachment')->nullable();
            $table->string('fine')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('renewal_visa_stampings');
    }
}
