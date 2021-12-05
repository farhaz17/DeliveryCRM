<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('part_id');
            $table->bigInteger('qty');
            $table->double('price');
            $table->integer('purhcase_id');
            $table->integer('status');
            $table->timestamps();
        });
    }
    //status 0 for new entry
    //status 1 for addition
    //status 2 for substraction


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parts_histories');
    }
}
