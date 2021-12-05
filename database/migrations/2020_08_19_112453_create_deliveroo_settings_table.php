<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverooSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveroo_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('attendance_critical_value')->nullable();
            $table->bigInteger('attendance_bad_value')->nullable();
            $table->bigInteger('attendance_good_value')->nullable();
            $table->bigInteger('unassigned_critical_value')->nullable();
            $table->bigInteger('unassigned_bad_value')->nullable();
            $table->bigInteger('unassigned_good_value')->nullable();
            $table->bigInteger('wait_critical_value')->nullable();
            $table->bigInteger('wait_bad_value')->nullable();
            $table->bigInteger('wait_good_value')->nullable();
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
        Schema::dropIfExists('deliveroo_settings');
    }
}
