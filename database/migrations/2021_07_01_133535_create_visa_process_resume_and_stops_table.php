<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisaProcessResumeAndStopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visa_process_resume_and_stops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->bigInteger('visa_process_step_id');
            $table->text('remarks');
            $table->dateTime('time_and_date');
            $table->text('resume_remarks');
            $table->dateTime('resume_time_and_date');
            $table->bigInteger('user_id');
            $table->integer('status')->comment('1 for stop, 2 for resume');
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
        Schema::dropIfExists('visa_process_resume_and_stops');
    }
}
