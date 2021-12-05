<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDuplicateCodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('duplicate_cod', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_id');
            $table->date('order_date');
            $table->string('city');
            $table->string('rider_id');
            $table->string('agency');
            $table->string('amount');
            $table->bigInteger('platform_id');
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
        Schema::dropIfExists('duplicate_cod');
    }
}
