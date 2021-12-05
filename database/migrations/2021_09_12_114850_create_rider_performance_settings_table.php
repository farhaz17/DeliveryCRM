<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiderPerformanceSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_performance_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('setting_name');
            $table->unsignedBigInteger('platform_id');
            $table->string('date_column_name')->comment('Date column of Performance table');
            $table->json('column_settings');
            $table->text('setting_description')->nullable();
            $table->string('performance_model');
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
        Schema::dropIfExists('rider_performance_settings');
    }
}
