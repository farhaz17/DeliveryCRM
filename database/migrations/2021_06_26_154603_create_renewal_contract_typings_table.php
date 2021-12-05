<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewalContractTypingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewal_contract_typings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('passport_id');
            $table->string('mb_no');
            $table->text('attachments')->nullable();
            $table->double('fine_amount')->nullable();
            $table->double('payment_amount')->nullable();
            $table->bigInteger('payment_type')->nullable();
            $table->string('transaction_number')->nullable();
            $table->date('transaction_date')->nullable();
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
        Schema::dropIfExists('renewal_contract_typings');
    }
}
