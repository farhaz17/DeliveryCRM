<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWpsBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wps_bank_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("passport_id");
            $table->string("bank_name")->nullable();
            $table->string("iban_no")->nullable();
            $table->string("attachment")->nullable();
            $table->string("remarks")->nullable();
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
        Schema::dropIfExists('wps_bank_details');
    }
}
