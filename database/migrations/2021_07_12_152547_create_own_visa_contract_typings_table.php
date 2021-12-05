<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnVisaContractTypingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('own_visa_contract_typings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id')->nullable();
            $table->text('attachment')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('mb_no')->nullable();
            $table->string('company')->nullable();
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
        Schema::dropIfExists('own_visa_contract_typings');
    }
}
