<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company');
            $table->string('job_title');
            $table->integer('state');
            $table->text('job_description');
            $table->string('qualification');
            $table->string('experience');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('status')->comment('1 for active, 2 for inactive');
            $table->string('refrence_no');

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
        Schema::dropIfExists('create_jobs');
    }
}
