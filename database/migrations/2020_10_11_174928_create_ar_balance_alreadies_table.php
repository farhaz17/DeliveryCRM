<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArBalanceAlreadiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_balance_alreadies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('zds_code');
            $table->bigInteger('rider_id')->nullable();
            $table->string('name')->nullable();
            $table->double('agreed_amount')->nullable();
            $table->double('cash_received')->nullable();
            $table->double('discount')->nullable();
            $table->double('deduction')->nullable();
            $table->double('balance');
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
        Schema::dropIfExists('ar_balance_alreadies');
    }
}
