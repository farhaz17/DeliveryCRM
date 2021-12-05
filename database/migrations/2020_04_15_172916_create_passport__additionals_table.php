<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePassportAdditionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passport_additionals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('nation_id');
            $table->string('additional_name');
            $table->string('additional_name_field');
            $table->string('type_id');
            $table->string('placeholder');
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
        Schema::dropIfExists('passport_additionals');
    }
}
