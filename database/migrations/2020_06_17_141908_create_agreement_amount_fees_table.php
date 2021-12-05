<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgreementAmountFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_amount_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('employee_type_id')->nullable();
            $table->bigInteger('current_status_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->string('option_label')->nullable();
            $table->integer('option_value')->nullable();
            $table->integer('child_option_id')->nullable();
            $table->double('amount')->nullable();
            $table->timestamps();
        });
        //if option_label is e-visa print and option value =1 then child option id =1 means that inside status change
        // if option_label is e-visa print and option value =1 then child option id =2 means that outside status change
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agreement_amount_fees');
    }
}
