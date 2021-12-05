<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWpsPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wps_payment_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("passport_id");
            $table->bigInteger("payment_method"); // 1-C3 2-Bank 3-By-Hand
            $table->string("payment_method_details")->nullable();
            $table->bigInteger('by_hand_id')->nullable(); // 1-Lulu 2-Hand
            $table->bigInteger('active')->nullable();  //1-active
            $table->softDeletes();
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
        Schema::dropIfExists('wps_payment_details');
    }
}
