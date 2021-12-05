<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRiderFuelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_fuels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('amount');
            $table->text('image');
            $table->integer('status')->default(0); // 0 = pending, 1= approved, 2=rejected
            $table->bigInteger('passport_id');
            $table->bigInteger('action_by')->nullable();
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
        Schema::dropIfExists('rider_fuels');
    }
}
