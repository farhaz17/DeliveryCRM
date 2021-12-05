<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLpoPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpo_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('lpo_id');
            $table->integer('payment_method')->nullable();
            $table->integer('cheque_id')->nullable();
            $table->integer('created_user_id')->nullable();
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
        Schema::dropIfExists('lpo_payments');
    }
}
