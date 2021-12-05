<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeListPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_list_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('no');
            $table->string('person_code');
            $table->string('person_name');
            $table->string('job');
            $table->string('passport_details');
            $table->string('card_details');
            $table->string('deleted_at')->nullable();
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
        Schema::dropIfExists('employee_list_payment');
    }
}
