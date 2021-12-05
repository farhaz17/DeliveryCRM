<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareemCodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('careem_cod', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('passport_id');
            $table->date('date');
            $table->string('time');
            $table->double('amount');
            $table->string('message')->nullable();
            $table->string('image')->nullable();
            $table->string('type')->comment('1=cash, 0=bank');
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
        Schema::dropIfExists('careem_cod');
    }
}
