<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePriceHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('part_id');
            $table->double('price');
            $table->date('date_from');
            $table->date('date_to');
            $table->integer('source');//0 means new price added, 1 means price was editted
            $table->bigInteger('added_by');//0 means new price added, 1 means price was editted
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
        Schema::dropIfExists('price_histories');
    }
}
