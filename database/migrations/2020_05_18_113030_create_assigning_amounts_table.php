<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssigningAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigning_amounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('amount');
            $table->bigInteger('master_step_id');
            $table->bigInteger('passport_id');
            $table->bigInteger('agreement_id');
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
        Schema::dropIfExists('assigning_amounts');
    }
}
