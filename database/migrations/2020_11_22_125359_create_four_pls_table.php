<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFourPlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('four_pls', function (Blueprint $table) {
            $table->bigIncrements('id');
//            $table->string('name');
            $table->string('phone_no');
            $table->string('four_pl_code');
            $table->Integer('four_pl_type');
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
        Schema::dropIfExists('four_pls');
    }
}
