<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareemRiderPerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('careem_rider_performances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uploaded_file_path');
            $table->string('rider_platform_code');
            $table->bigInteger('passport_id'); // instead of rider name and rider id we will store passport id of that rider
            $table->timestamp('start_date');
            $table->timestamp('end_date');

            $table->string('limocompany')->nullable();
            $table->string('cct')->nullable();
            $table->Integer('trips')->nullable();
            $table->decimal('earnings')->nullable();
            $table->decimal('available_hours')->nullable();
            $table->decimal('average_rating')->nullable();
            $table->decimal('acceptance_rate')->nullable();
            $table->integer('completed_trips')->nullable();
            $table->decimal('cash_collected')->nullable();
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
        Schema::dropIfExists('careem_rider_performances');
    }
}
