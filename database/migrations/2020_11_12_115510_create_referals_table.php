<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('passport_id');
            $table->string('name');
            $table->string('passport_no')->nullable();
            $table->string('driving_license');
            $table->string('driving_attachment')->nullable();
            $table->integer('status')->default('0');
            $table->double('credit_amount')->nullable();
            $table->integer('credit_status')->default('0');//0 for not paid and 1 for paid
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
        Schema::dropIfExists('referals');
    }
}
