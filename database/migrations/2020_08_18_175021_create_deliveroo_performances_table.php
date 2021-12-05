<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverooPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveroo_performances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rider_id')->nullable();
            $table->string('rider_name')->nullable();
            $table->bigInteger('hours_scheduled')->nullable();
            $table->bigInteger('hours_worked')->nullable();
            $table->string('attendance')->nullable();
            $table->bigInteger('no_of_orders_delivered')->nullable();
            $table->bigInteger('no_of_orders_unassignedr')->nullable();
            $table->bigInteger('unassigned')->nullable();
            $table->bigInteger('wait_time_at_customer')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
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
        Schema::dropIfExists('deliveroo_performances');
    }
}
