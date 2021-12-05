<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('job_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email_address');
            $table->string('phone_no');
            $table->string('education');
            $table->string('cv');
            $table->text('cover_letter');
            $table->string('last_company');
            $table->text('comments');
            $table->text('question');
            $table->text('references');
            $table->integer('status')->default('0')->comment('0 for no action, 1 accept, 2 reject');


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
        Schema::dropIfExists('jobs_applications');
    }
}
