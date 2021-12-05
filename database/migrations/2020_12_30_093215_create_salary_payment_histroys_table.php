<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryPaymentHistroysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_payment_histroys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('platform_id_name');
            $table->bigInteger('platform_id');
            $table->string('zds_code');
            $table->date('on_board')->nullable();
            $table->date('off_board')->nullable();
            $table->string('name');
            $table->date('date_from');
            $table->date('date_to');
            $table->integer('balance_type');
            $table->double('amount');
            $table->double('status');
            $table->double('net_payment')->nullable();
            $table->double('amount_paid')->nullable();
            $table->double('balance');
            $table->timestamps();
        });
    }

//$table->integer('platform_id_name');
//$table->date('date_from');
//$table->date('date_to');
//$table->bigInteger('platform_id');
//$table->string('zds_code');
//$table->string('name');
//$table->double('prebal');
//$table->double('gross_pay');
//$table->double('add');
//$table->double('penalty_return');
//$table->double('adjustment');
//$table->double('bike_rent');
//$table->double('sim_charge');
//$table->double('salik');
//$table->double('fine');
//$table->double('advance');
//$table->double('fuel');
//$table->double('loss_damage');
//$table->double('cod_penalty');
//$table->double('platform_penalty');
//$table->double('hours_deduction');
//$table->double('loan_deduction');
//$table->double('sim_excess');
//$table->double('others');
//$table->double('sub');
//$table->double('net_payment');
//$table->double('amount_paid');
//$table->double('balance');

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_payment_histroys');
    }
}
