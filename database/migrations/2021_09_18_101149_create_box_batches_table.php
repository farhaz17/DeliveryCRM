<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoxBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box_batches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('platform_id');
            $table->string('reference_number');
            $table->date('date');
            $table->string('location');
            $table->bigInteger('bike_quantity');
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
        Schema::dropIfExists('box_batches');
    }
}
