<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisaCancelPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_cancel_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('step_id');
            $table->bigInteger('passport_id')->nullable();
            $table->double('payment_amount')->nullable();
            $table->integer('payment_type')->nullable();
            $table->string('transaction_no')->nullable();
            $table->date('transaction_date')->nullable();
            $table->string('other_attachment')->nullable();
            $table->double('vat')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('visa_cancel_payments');
    }
}
