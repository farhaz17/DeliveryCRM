<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPartialAmountStepAndParitalAmountAndPartialAmountStatusBioToAssigningAmounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assigning_amounts', function (Blueprint $table) {
            //
            $table->integer('partial_amount_step')->nullable();
            $table->double('partial_amount')->nullable();
            $table->integer('partial_amount_status')->nullable(); //1 for step 2 for payroll deduct
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assigning_amounts', function (Blueprint $table) {
            //
        });
    }
}
