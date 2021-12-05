<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReplacementVisaCancelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replacement_visa_cancels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->bigInteger('replaced_passport_id');
            $table->bigInteger('stop_and_resume_id');
            $table->bigInteger('visa_process_id');
            $table->bigInteger('user_id');
            $table->text('remarks');
            $table->integer('status')->default('1')->comment('1 for complete, 2 for cancel replacement');
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
        Schema::dropIfExists('replacement_visa_cancels');
    }
}
