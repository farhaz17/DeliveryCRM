<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedical48sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical48s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id')->nullable();
            $table->string('medical_tans_no')->nullable();
            $table->string('medical_date_time')->nullable();
            $table->string('payment_amount')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('transaction_no')->nullable();
            $table->string('transaction_date_time')->nullable();
            $table->string('vat')->nullable();
            $table->bigInteger('attachment_id')->nullable();
            $table->string('is_complete')->default('0');

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
        Schema::dropIfExists('medical48s');
    }
}
