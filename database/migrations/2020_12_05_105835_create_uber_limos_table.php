<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUberLimosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uber_limos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('driver_u_uid');
            $table->string('trip_u_uid');
            $table->string('first_name');
            $table->string('last_name');
            $table->double('amount');
            $table->string('timestamp');
            $table->string('item_type');
            $table->string('description');
            $table->string('disclaimer')->nullable();
            $table->date('date_from');
            $table->date('date_to');
            $table->bigInteger('file_path');
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
        Schema::dropIfExists('uber_limos');
    }
}
