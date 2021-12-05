<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('part_id');
            $table->double('price');
            $table->integer('status');
            $table->timestamps();
        });
        //status=0 current price is active
        //status=1 current price is deactive
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('current_prices');
    }
}
