<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTelecomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telecomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_number');
            $table->string('party_id');
            $table->string('product_type');
            $table->string('network');
            $table->bigInteger('status')->default('0');

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
        Schema::dropIfExists('telecomes');
    }
}
