<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWpsLuluCardDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wps_lulu_card_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("passport_id");
            $table->string("card_no")->nullable();
            $table->string("code_no")->nullable();
            $table->string("expiry")->nullable();
            $table->string("attachment")->nullable();
            $table->string("remarks")->nullable();
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
        Schema::dropIfExists('wps_lulu_card_details');
    }
}
