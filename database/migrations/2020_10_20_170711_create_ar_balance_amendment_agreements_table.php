<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArBalanceAmendmentAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_balance_amendment_agreements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('agreement_amendment_id');
            $table->double('ar_agreed_amount');
            $table->double('ar_cash_received_amount');
            $table->double('ar_discount_amount');
            $table->double('total_deduction_amount');
            $table->double('total_addition_amount');
            $table->double('current_balance');
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
        Schema::dropIfExists('ar_balance_amendment_agreements');
    }
}
