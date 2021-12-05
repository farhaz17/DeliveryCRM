<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDcRequestForCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_request_for_checkouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('request_by_id');
            $table->bigInteger('approve_by_id')->nullable();
            $table->bigInteger('rider_passport_id');
            $table->dateTime('checkout_date_time');
            $table->integer('checkout_type');
            $table->text('remarks');
            $table->integer('request_status')->default(0); //0 pending, 1= approved, 2=rejected
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
        Schema::dropIfExists('dc_request_for_checkouts');
    }
}
